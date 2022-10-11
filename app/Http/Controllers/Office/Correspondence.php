<?php

namespace App\Http\Controllers\Office;

use Auth;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Requests\{
    Core\UpdateCorrespondence,
    Office\Correspondence\GetCorrespondences,
    Office\Correspondence\ResponseCorrespondence,
};
use App\Services\Core\Correspondence as CorrespondenceService;
use App\Repositories\Core\Correspondence as CorrespondenceRepository;
use App\Http\Transformers\Core\Correspondence as CorrespondenceTransformer;

/**
 * @group Office Correspondence
 *
 */
class Correspondence extends Controller
{
    /** @var CorrespondenceService */
    private CorrespondenceService $correspondenceService;
    /** @var CorrespondenceRepository */
    private CorrespondenceRepository $correspondenceRepository;

    /**
     * Correspondence constructor.
     * @param CorrespondenceService $correspondenceService
     * @param CorrespondenceRepository $correspondenceRepository
     */
    public function __construct(CorrespondenceService $correspondenceService, CorrespondenceRepository $correspondenceRepository){
        $this->correspondenceService    = $correspondenceService;
        $this->correspondenceRepository = $correspondenceRepository;
    }

    /**
     * @param GetCorrespondences $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     */
    public function getCorrespondences(GetCorrespondences $objRequest){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        [$objCorrespondences, $availableMetaData] = $this->correspondenceRepository->findAll($objRequest->input("per_page", 10), $objRequest->all());

        return ($this->apiReply($objCorrespondences, "", Response::HTTP_OK, $availableMetaData));
    }

    /**
     * @param string $correspondenceUUID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCorrespondenceByUuid(string $correspondenceUUID){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objCorrespondence = $this->correspondenceRepository->findByUuid($correspondenceUUID);

        return ($this->item($objCorrespondence, new CorrespondenceTransformer));
    }

    /**
     * @param string $correspondenceUUID
     * @param UpdateCorrespondence $request
     * @return mixed
     */
    public function updateCorrespondenceByUuid(string $correspondenceUUID, UpdateCorrespondence $request){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->correspondenceRepository->updateByUuid(
            $correspondenceUUID,
            $request->only(["flag_read", "flag_archived", "flag_received"])
        );

        if ($boolResult) {
            return ($this->apiReply(null, "Correspondence updated successfully."));
        }

        return ($this->apiReject(null, "Correspondence hasn't updated."));
    }

    /**
     * @param string $correspondenceUUID
     * @param ResponseCorrespondence $objRequest
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|Response|object
     * @throws \Exception
     */
    public function responseForCorrespondence(string $correspondenceUUID, ResponseCorrespondence $objRequest){
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->correspondenceService->responseForCorrespondence($correspondenceUUID, $objRequest->only(["text", "attachments"]));

        if ($boolResult) {
            return ($this->apiReply(null, "Response sent successfully."));
        }

        return ($this->apiReject(null, "Response hasn't sent."));
    }
}
