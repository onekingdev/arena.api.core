<?php

namespace App\Http\Controllers\Soundblock;

use Client;
use Builder;
use Exception;
use App\Models\Users\User;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Models\Soundblock\Projects\Project;
use App\Events\Soundblock\UpdateDeployments;
use App\Jobs\Soundblock\Ledger\DeploymentLedger;
use App\Jobs\Soundblock\Projects\Deployemnts\Zip;
use Illuminate\Support\Facades\Auth as AuthFacade;
use App\Http\Transformers\Soundblock\Deployment as DeploymentTransformer;
use App\Http\Requests\{
    Office\Project\Deployment\CreateDeployments,
    Soundblock\Project\Deploy\CreateDeployment,
    Soundblock\Project\Deploy\GetDeployment,
    Soundblock\Project\Deploy\UpdateDeployment
};
use App\Services\{
    Common\App as AppService,
    Soundblock\Project as ProjectService,
    Soundblock\Collection as CollectionService,
    Soundblock\Contracts\Service as ContractService,
    Soundblock\Deployment as DeploymentService,
    Soundblock\Ledger\DeploymentLedger as DeploymentLedgerService
};

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class Deployment extends Controller
{
    private DeploymentService $deploymentService;
    private ContractService $objContractService;
    private ProjectService $projectService;
    /** @var CollectionService */
    private CollectionService $collectionService;
    /** @var AppService */
    private AppService $appService;

    /**
     * Deployment constructor.
     * @param DeploymentService $deploymentService
     * @param ProjectService $projectService
     * @param ContractService $objContractService
     * @param CollectionService $collectionService
     * @param AppService $appService
     */
    public function __construct(DeploymentService $deploymentService, ProjectService $projectService, AppService $appService,
                                ContractService $objContractService, CollectionService $collectionService) {
        $this->deploymentService = $deploymentService;
        $this->objContractService = $objContractService;
        $this->projectService = $projectService;
        $this->collectionService = $collectionService;
        $this->appService = $appService;
    }

    /**
     * @param string $project
     * @param GetDeployment $objRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function index(string $project, GetDeployment $objRequest) {
        if (!$this->projectService->checkUserInProject($project, AuthFacade::user())) {
            return ($this->apiReject(null, "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $arrDeployments = $this->deploymentService->findAllByProject($project, $objRequest->per_page);

        return ($this->paginator($arrDeployments, new DeploymentTransformer(["platform", "status", "collection"])));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param string $project
     * @param CreateDeployment $objRequest
     * @return \Illuminate\Http\Response
     * @throws Exception
     */
    public function store(string $project, CreateDeployment $objRequest) {
        /** @var User $objUser */
        $objUser = AuthFacade::user();
        /** @var Project $objProject*/
        $objProject = $this->projectService->find($project, true);

        $strSoundGroup = sprintf("App.Soundblock.Account.%s", $objProject->account_uuid);

        if (!is_authorized($objUser, $strSoundGroup, "App.Soundblock.Account.Project.Deploy", "soundblock", true, true)) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        if (!$this->objContractService->checkActiveContract($objProject)) {
            return $this->apiReply(null, "Cannot Deploy Project Without Active Contract.", Response::HTTP_FORBIDDEN);
        }

        if ($objRequest->has("collectionUUID")) {
            $objCollection = $this->collectionService->find($objRequest->input("collectionUUID"), false);
        } else {
            $objCollection = $this->collectionService->findLatestByProject($objProject);
        }

        if (is_null($objCollection)) {
            return $this->apiReject("", "Collection Not Found", 404);
        }

        $objDeployment = $this->deploymentService->create($objProject, $objRequest->input("platforms"), $objCollection->collection_uuid);

        $objQueue = $this->projectService->createJob("Job.Soundblock.Project.Deployment.Zip", AuthFacade::user(), Client::app());
        dispatch(new Zip($objCollection, $objQueue));
        event(new UpdateDeployments($objProject));

        $objApp = $this->appService->findOneByName("office");
        $strNotificationArtistName = isset($objProject->artist) ? "by {$objProject->artist->artist_name}" : "";
        $strMemo = "&quot;{$objProject->project_title}&quot; {$strNotificationArtistName} <br>Soundblock &bull; {$objProject->account->account_name}";

        notify_group("App.Office", $objApp, "Deployment Requested", $strMemo, Builder::notification_link([
            "link_name" => "Check Deployments",
            "url"       => app_url("office") . "soundblock/deployments",
        ]));

        return ($this->apiReply($objDeployment));
    }

    /**
     * @param CreateDeployments $objRequest
     * @return \Illuminate\Http\JsonResponse
     * @throws Exception
     */
    public function storeMultiple(CreateDeployments $objRequest) {
        $objUser = AuthFacade::user();

        if (!is_authorized($objUser, "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $arrDeployments = $this->deploymentService->createMultiple($objRequest->all());

        return ($this->collection($arrDeployments, new DeploymentTransformer(["status", "platform"])));
    }

    /**
     * @param string $project
     * @param string $deployment
     * @param UpdateDeployment $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws Exception
     */
    public function update(string $project, string $deployment, UpdateDeployment $objRequest){
        $objProject = $this->projectService->find($project, false);

        if (empty($objProject)) {
            return ($this->apiReject(null, "Undefined project.", 400));
        }

        $strSoundGroup = sprintf("App.Soundblock.Account.%s", $objProject->account_uuid);

        if (!is_authorized(AuthFacade::user(), $strSoundGroup, "App.Soundblock.Account.Project.Deploy", "soundblock", true, true)) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objDeployment = $objProject->deployments()->where("deployment_uuid", $deployment)->first();

        if (empty($objDeployment)) {
            return ($this->apiReject(null, "Project doesn't have such deployment.", 400));
        }

        $arrUpdate = [];
        if ($objRequest->input("status") == "takedown") {
            $arrUpdate["deployment_status"] = "Pending takedown";
            $strLedgerEvent = DeploymentLedgerService::TAKE_DOWN;
        } elseif ($objRequest->input("status") == "redeploy") {
            $arrUpdate["deployment_status"] = "Redeploy";
            $arrUpdate["collection"] = $objRequest->input("collection");
            $strLedgerEvent = DeploymentLedgerService::CHANGE_COLLECTION;
        } else {
            return ($this->apiReject(null, "Invalid Status.", 400));
        }

        $objDeployment = $this->deploymentService->update($objDeployment, $arrUpdate);

        event(new UpdateDeployments($objProject));
        dispatch(new DeploymentLedger($objDeployment, $strLedgerEvent))->onQueue("ledger");

        return ($this->apiReply($objDeployment, "Deployment updated successfully.", 200));
    }
}
