<?php

namespace App\Http\Controllers\Office;

use Auth;
use Carbon\Carbon;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Helpers\Filesystem\Soundblock;
use App\Jobs\Soundblock\Ledger\DeploymentLedger;
use App\Services\{
    Soundblock\Project as ProjectService,
    Soundblock\Deployment as DeploymentService,
    Soundblock\Collection as CollectionService,
    Soundblock\Contracts\Service as ContractService
};
use App\Http\Requests\{
    Office\Project\Deployment\GetDeployments,
    Office\Project\Deployment\UpdateDeployment,
    Office\Project\Deployment\GetAllDeployments,
    Soundblock\Project\Deploy\CreateDeployment
};

/**
 * @group Office Soundblock
 *
 */
class Deployment extends Controller
{
    /** @var DeploymentService */
    private DeploymentService $deploymentService;
    /** @var ProjectService */
    private ProjectService $projectService;
    /** @var ContractService */
    private ContractService $contractService;
    private CollectionService $collectionService;

    /**
     * Deployment constructor.
     * @param DeploymentService $deploymentService
     * @param ProjectService $projectService
     * @param ContractService $contractService
     * @param CollectionService $collectionService
     */
    public function __construct(DeploymentService $deploymentService, ProjectService $projectService,
                                ContractService $contractService, CollectionService $collectionService) {
        $this->deploymentService = $deploymentService;
        $this->projectService    = $projectService;
        $this->contractService   = $contractService;
        $this->collectionService = $collectionService;
    }

    /**
     * @param GetDeployments $objRequest
     * @param string $project
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\JsonResponse|Response|object
     * @throws \Exception
     */
    public function index(GetDeployments $objRequest, string $project) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $perPage = $objRequest->input("per_page", 10);
        $arrDeployments = $this->deploymentService->findProjectDeployments($project, $perPage);

        return ($this->apiReply($arrDeployments, "", Response::HTTP_OK));
    }

    /**
     * @param GetAllDeployments $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function getAllDeployments(GetAllDeployments $objRequest){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $arrSort = $objRequest->only(["sort_project", "sort_created_at"]);
        [$objDeployments, $availableMetaData] = $this->deploymentService->findAll($objRequest->all(), $arrSort, true);

        return ($this->apiReply($objDeployments, "", Response::HTTP_OK, $availableMetaData));
    }

    /**
     * @param string $deployment
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function getDeploymentDetails(string $deployment){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $deploymentInfo = $this->deploymentService->getDeploymentInfo($deployment);

        return ($this->apiReply($deploymentInfo, "", 200));
    }

    public function downloadZip(string $deployment) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objDeployment = $this->deploymentService->find($deployment, false);

        if (is_null($objDeployment)) {
            return $this->apiReject("", "Deployment Not Found.", 404);
        }

        $objCollection = $objDeployment->collection;
        $objBucket = bucket_storage("office");

        if (!$objBucket->exists("public/" . Soundblock::office_deployment_project_zip_path($objCollection))) {
            return $this->apiReject("", "Deployment Zip Not Found.", 404);
        }

        $strDownloadLink = cloud_url("office") . Soundblock::office_deployment_project_zip_path($objCollection);

        return ($this->apiReply(["download_link" => $strDownloadLink],"",Response::HTTP_OK));
    }

    public function getDeploymentsByCollection(string $collection) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objCollection = $this->collectionService->find($collection);

        if (is_null($objCollection)) {
            return $this->apiReject(null, "Collection Not Found.", Response::HTTP_NOT_FOUND);
        }

        $arrDeploymentInfo = $this->deploymentService->getCollectionDeployments($objCollection);

        return $this->apiReply($arrDeploymentInfo);
    }

    /**
     * @param string $project
     * @param CreateDeployment $objRequest
     * @return \Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function store(string $project, CreateDeployment $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $project = $this->projectService->find($project, true);

        if (!$this->contractService->checkActiveContract($project)) {
            return $this->apiReply(null, "Cannot Deploy Project Without Active Contract.", Response::HTTP_FORBIDDEN);
        }

        $objDeployment = $this->deploymentService->create($project, $objRequest->input("platforms"), $objRequest->input("collection"));

        return ($this->apiReply($objDeployment));
    }

    /**
     * @param UpdateDeployment $objRequest
     * @param string $deployment
     * @return Deployment|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function updateDeployment(UpdateDeployment $objRequest, string $deployment) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objDeployment = $this->deploymentService->find($deployment);
        $objDeployment = $this->deploymentService->update($objDeployment, $objRequest->all());

        dispatch(new DeploymentLedger($objDeployment, $objRequest->input("deployment_status"), true))->onQueue("ledger");

        return ($this->apiReply($objDeployment, "Deployment has been updated successfully.", 200));
    }

    public function updateCollectionDeployments(string $collection, UpdateDeployment $objRequest) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objCollection = $this->collectionService->find($collection);

        if (is_null($objCollection)) {
            return $this->apiReject(null, "Collection Not Found.", Response::HTTP_NOT_FOUND);
        }

        $this->deploymentService->updateCollectionDeployments($objCollection, $objRequest->all());
        $arrDeploymentInfo = $this->deploymentService->getCollectionDeployments($objCollection);

        return $this->apiReply($arrDeploymentInfo);
    }
}
