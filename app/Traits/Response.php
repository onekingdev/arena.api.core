<?php

namespace App\Traits;

use Illuminate\Http\Response as BaseResponse;

trait Response {

    /**
     * @param mixed $objData
     * @param string $strMessage
     * @param int $intStatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function failure($objData = null, string $strMessage = "", $intStatus = BaseResponse::HTTP_EXPECTATION_FAILED): \Illuminate\Http\JsonResponse {
        return ($this->respond($objData, $strMessage, $intStatus));
    }

    /**
     * @param mixed $objData
     * @param string $strMessage
     * @param int $intStatus
     * @return \Illuminate\Http\JsonResponse
     */
    public function respond($objData, string $strMessage, int $intStatus = BaseResponse::HTTP_OK) {
        return (response()->json([
            "response" => $objData,
            "status"   => [
                "app"     => "Arena.API",
                "code"    => $intStatus,
                "message" => $strMessage,
            ]], $intStatus));
    }
}
