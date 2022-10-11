<?php

namespace App\Http\Controllers\Core;

use App\Http\Controllers\Controller;
use App\Services\Common\App as AppService;
use App\Http\Transformers\Common\App as AppTransformer;

/**
 * @group Core
 *
 */
class App extends Controller {

    /**
     * @param AppService $appService
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(AppService $appService) {
        $arrApp = $appService->findAll();
        return ($this->collection($arrApp, new AppTransformer));
    }
}
