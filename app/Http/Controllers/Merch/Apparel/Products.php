<?php

namespace App\Http\Controllers\Merch\Apparel;

use App\Facades\Cache\AppCache;
use App\Http\Controllers\Controller;
use App\Services\Apparel\Product as ProductService;
use App\Traits\Cacheable;
use Illuminate\Http\Request;

/**
 * @group Merch Apparel
 *
 */
class Products extends Controller {
    use Cacheable;

    /**
     * @var ProductService
     */
    private ProductService $productService;

    /**
     * Products constructor.
     * @param ProductService $productService
     */
    public function __construct(ProductService $productService) {
        $this->productService = $productService;
    }

    /**
     * @param string $productUuid
     * @param Request $request
     * @return \App\Http\Resources\Common\BaseCollection|\Illuminate\Http\JsonResponse
     */
    public function get(string $productUuid, Request $request) {
        AppCache::setRequestOptions($request->path(), $request->all());

        [$isCached, $objProduct] = $this->productService->getProduct($productUuid, $request->input("color"));

        if ($isCached) {
            return response()->json(AppCache::getCache());
        }

        return ($this->sendCacheResponse($this->apiReply($objProduct), "apparel"));
    }
}
