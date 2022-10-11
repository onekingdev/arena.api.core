<?php

namespace App\Http\Controllers;

use Illuminate\{Http\Resources\Json\ResourceCollection,
    Http\Response,
    Foundation\Bus\DispatchesJobs,
    Pagination\LengthAwarePaginator,
    Routing\Controller as BaseController,
    Foundation\Validation\ValidatesRequests,
    Foundation\Auth\Access\AuthorizesRequests};

use League\Fractal\{
    Manager,
    Resource\Item,
    TransformerAbstract,
    Resource\Collection,
    Pagination\IlluminatePaginatorAdapter,
};

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function apiReply($objData = null, string $strMessage = "", int $intStatus = Response::HTTP_OK, array $metaData = null) {
        if ($objData instanceof ResourceCollection) {
            return $objData;
        }

        return ($this->respond($objData, $strMessage, $intStatus, $metaData));
    }

    public function respond($objData, string $strMessage, int $intStatus = Response::HTTP_OK, $metaData = null) {
        return (response([
            "data"   => $objData,
            "status" => [
                "app"     => "Arena.API",
                "code"    => $intStatus,
                "message" => $strMessage,
            ],
            "meta" => $metaData
        ])->setStatusCode($intStatus));
    }

    public function apiReject($objData = null, string $strMessage = "", int $intStatus = Response::HTTP_EXPECTATION_FAILED) {
        return ($this->respond($objData, $strMessage, $intStatus));
    }

    public function item($data, TransformerAbstract $transformer) {
        return response()->json((new Manager)->createData(new Item($data, $transformer))->toArray());
    }

    public function collection($data, TransformerAbstract $transformer) {
        return response()->json((new Manager)->createData(new Collection($data, $transformer))->toArray());
    }

    public function paginator(LengthAwarePaginator $data, TransformerAbstract $transformer, array $metaData = null) {
        $collection = $data->getCollection();

        $resource = new Collection($collection, $transformer);
        $resource->setPaginator(new IlluminatePaginatorAdapter($data));

        if (isset($metaData)) {
            $resource->setMeta($metaData);
        }

        return response()->json((new Manager)->createData($resource)->toArray());
    }
}
