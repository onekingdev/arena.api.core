<?php

namespace App\Http\Controllers\Soundblock;

use App\Http\Controllers\Controller;
use App\Http\Transformers\Platform as PlatformTransformer;
use App\Http\Requests\Soundblock\Platforms\Platform as PlatformRequest;
use App\Services\Soundblock\{Collection as CollectionService, Project as ProjectService, Platform as PlatformService};

/**
 * @group Soundblock
 *
 * Soundblock routes
 */
class Platform extends Controller {

    protected PlatformService $platformService;
    /** @var ProjectService */
    private ProjectService $projectService;
    /** @var CollectionService */
    private CollectionService $collectionService;

    /**
     * Platform constructor.
     * @param PlatformService $platformService
     * @param ProjectService $projectService
     * @param CollectionService $collectionService
     */
    public function __construct(PlatformService $platformService, ProjectService $projectService,
                                CollectionService $collectionService) {
        $this->platformService = $platformService;
        $this->projectService = $projectService;
        $this->collectionService = $collectionService;
    }

    /**
     * @responseFile responses/soundblock/platform/get-all-platforms.get.json
     * @param PlatformRequest $objRequest
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(PlatformRequest $objRequest) {
        if ($objRequest->has("project")) {
            $objProject = $this->projectService->find($objRequest->input("project"));
            $arrPlatforms = $this->platformService->findNotDeployedForProject($objProject, $objRequest->input("category"));
        } else if ($objRequest->has("collection")) {
            $objCollection = $this->collectionService->find($objRequest->input("collection"));
            $arrPlatforms = $this->platformService->findNotDeployedForCollection($objCollection, $objRequest->input("category"));
        } else {
            $arrPlatforms = $this->platformService->findAll($objRequest->input("category"));
        }

        return ($this->collection($arrPlatforms, new PlatformTransformer));
    }
}
