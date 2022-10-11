<?php

namespace App\Http\Controllers\Core;

use App\Http\{Controllers\Controller,
    Requests\Core\CreateCorrespondence};
use App\Services\Core\Correspondence as CorrespondenceService;

/**
 * @group Core
 *
 */
class Correspondence extends Controller
{
    /**
     * @var CorrespondenceService
     */
    private CorrespondenceService $correspondenceService;

    /**
     * Correspondence constructor.
     * @param CorrespondenceService $correspondenceService
     */
    public function __construct(CorrespondenceService $correspondenceService){
        $this->correspondenceService    = $correspondenceService;
    }

    /**
     * @group Core
     *
     * @param CreateCorrespondence $objRequest
     * @return mixed
     * @throws \Exception
     */
    public function createCorrespondence(CreateCorrespondence $objRequest){
        $attachments = $objRequest->file("attachments", []);
        $clientIp    = $objRequest->getClientIp();
        $clientHost  = $objRequest->getHost();

        $bnHasDuplicate = $this->correspondenceService->checkDuplicate($objRequest->input("email"),
            $objRequest->input("subject"), $objRequest->input("json"));

        if ($bnHasDuplicate) {
            return ($this->apiReject(null, "Duplicate Record.", 400));
        }

        $objCorrespondence = $this->correspondenceService->create($objRequest->post(), $clientIp, $clientHost, $attachments);

        if (is_null($objCorrespondence)) {
            return ($this->apiReject(null, "Correspondence hasn't created.", 400));
        }

        return ($this->apiReply($objCorrespondence, "Correspondence has created.", 200));
    }
}
