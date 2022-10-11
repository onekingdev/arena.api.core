<?php

namespace App\Http\Controllers\Office\Merch\Apparel;

use App\Http\{
    Controllers\Controller,
    Requests\Apparel\UpdateProductPrice,
    Requests\Apparel\CreateProductPrice,
    Transformers\Apparel\ProductPrice as ProductPriceTransformer,
};
use Illuminate\Http\Response;
use App\Services\Apparel\Product;
use Illuminate\Support\Facades\Auth;

/**
 * @group Office Merch
 *
 */
class ProductPrice extends Controller {
    /** @var Product */
    private Product $productService;

    /**
     * ProductPrice constructor.
     * @param Product $productService
     */
    public function __construct(Product $productService) {
        $this->productService = $productService;
    }

    /**
     * @param CreateProductPrice $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function createProductPrice(CreateProductPrice $request) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You Don't Have Required Permissions.", Response::HTTP_FORBIDDEN));
        }

        $objProductPrice = $this->productService->createProductPrice($request->only([
            "product_uuid",
            "product_price",
            "range_min",
            "range_max",
        ]));

        return ($this->item($objProductPrice, new ProductPriceTransformer));
    }

    /**
     * @param string $productUUID
     * @param string $productPriceUUID
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function deleteProductPrice(string $productUUID, string $productPriceUUID) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->productService->deleteProductPrice($productUUID, $productPriceUUID);

        if ($boolResult) {
            return (response("Product price deleted successfully.", 201));
        }

        return (response("Error, product price haven't deleted.", 400));
    }


    /**
     * @param UpdateProductPrice $request
     * @param string $productUUID
     * @param string $productPriceUUID
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function editProductPrice(UpdateProductPrice $request, string $productUUID, string $productPriceUUID) {
        if (!is_authorized(Auth::user(), "App.Office", "App.Office.Access", "office")) {
            return ($this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN));
        }

        $boolResult = $this->productService->editProductPrice(
            $request->only([
                "product_price",
                "range_min",
                "range_max",
            ]),
            $productUUID,
            $productPriceUUID
        );

        if ($boolResult) {
            return (response("Product price updated successfully.", 201));
        }

        return (response("Error, product price haven't updated.", 400));
    }
}
