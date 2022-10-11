<?php

namespace App\Http\Controllers\Soundblock;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Services\{Auth, Soundblock\File};
use Illuminate\Support\Facades\Auth as AuthFacade;
use App\Http\Transformers\Common\FileHistory as FileHistoryTransformer;

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class FileHistory extends Controller {
    /** @var Auth */
    protected Auth $authService;
    /** @var File */
    private File $fileService;

    /**
     * @param Auth $authService
     * @param File $fileService
     */
    public function __construct(Auth $authService, File $fileService) {
        $this->authService = $authService;
        $this->fileService = $fileService;
    }

    /**
     * @param Request $objRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $objRequest) {
        if (!is_authorized(AuthFacade::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objRequest->validate([
            "file" => "required|uuid",
        ]);

        $objFile = $this->fileService->find($objRequest->file);

        return ($this->collection($objFile->histories, new FileHistoryTransformer(["file", "collection"])));
    }
}
