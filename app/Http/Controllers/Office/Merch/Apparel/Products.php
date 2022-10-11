<?php

namespace App\Http\Controllers\Office\Merch\Apparel;

use App\Http\{
    Controllers\Controller,
    Requests\Apparel\EditProduct,
    Requests\Apparel\CreateProduct,
    Transformers\Apparel\Product,
    Transformers\Apparel\AllProducts
};
use App\Traits\Cacheable;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Facades\Cache\AppCache;
use Illuminate\Support\Facades\Auth;
use App\Services\Apparel\Product as ProductService;
use App\Repositories\Apparel\Product as ProductRepository;

/**
 * @group Office Merch
 *
 */
class Products extends Controller {
    use Cacheable;

    /** @var ProductService */
    private ProductService $productService;
    /** @var ProductRepository */
    private ProductRepository $productRepository;

    /**
     * Products constructor.
     * @param ProductService $productService
     * @param ProductRepository $productRepository
     */
    public function __construct(ProductService $productService, ProductRepository $productRepository) {
        $this->productService = $productService;
        $this->productRepository = $productRepository;
    }

    /**
     * @param string $productUuid
     * @param Request $request
     * @return object
     */
    public function get(string $productUuid, Request $request) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        AppCache::setRequestOptions($request->path(), $request->all());

        [$isCached, $objProduct] = $this->productService->getProduct($productUuid, $request->input("color"));

        if ($isCached) {
            return response()->json(AppCache::getCache());
        }

        return ($this->sendCacheResponse($this->apiReply($objProduct)));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProducts(Request $request) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $strCategoryUUID = $request->input('category_uuid', null);
        $perPage = $request->input('per_page', 10);
        $arrSort = [
            "field"     => $request->input("sort_field", "product_name"),
            "direction" => $request->input("sort_dir", "asc"),
        ];

        $objProducts = $this->productService->getAllProducts($perPage, $arrSort, $strCategoryUUID);

        return ($this->paginator($objProducts, new AllProducts));
    }

    /**
     * @param $strProductUUID
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProductByUuid($strProductUUID) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProduct = $this->productRepository->getProductByUuid($strProductUUID);

        if (is_null($objProduct)) {
            abort(404, "Product not found.");
        }

        return ($this->item($objProduct, new Product));
    }

    /**
     * @param EditProduct $request
     * @param $strProductUUID
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function editProductByUuid(EditProduct $request, $strProductUUID) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->productRepository->updateProduct($strProductUUID, $request->only([
            "product_name",
            "product_weight",
            "product_description",
            "product_meta_keywords",
            "product_meta_description",
        ]));

        AppCache::flushCacheByTag("apparel");

        if ($boolResult) {
            return (response("Product Updated Successfully.", 201));
        }

        return (response("Error, product haven't updated.", 400));
    }

    /**
     * @param $strProductUUID
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function deleteProductByUuid($strProductUUID) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->productRepository->deleteProduct($strProductUUID);

        AppCache::flushCacheByTag("apparel");

        if ($boolResult) {
            return (response("Product Deleted Successfully.", 201));
        }

        return (response("Error, product haven't deleted.", 400));
    }

    /**
     * @param CreateProduct $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function createProduct(CreateProduct $request) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProduct = $this->productRepository->createProduct($request);

        AppCache::flushCacheByTag("apparel");

        return ($this->item($objProduct, new Product));
    }
}
