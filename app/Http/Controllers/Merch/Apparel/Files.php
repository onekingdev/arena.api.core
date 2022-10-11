<?php

namespace App\Http\Controllers\Merch\Apparel;

use App\Http\Controllers\Controller;
use App\Services\Apparel\File;

/**
 * @group Merch Apparel
 *
 */
class Files extends Controller
{
    /**
     * @param string $file
     * @param File $fileService
     * @return \App\Http\Resources\Common\BaseCollection|\Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Resources\Json\ResourceCollection|\Illuminate\Http\Response|object
     * @throws \Exception
     */
    public function getFileUrl(string $file, File $fileService){
        return($this->apiReply($fileService->find($file)));
    }
}
