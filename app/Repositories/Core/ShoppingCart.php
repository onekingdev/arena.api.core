<?php

namespace App\Repositories\Core;

use Util;
use App\Repositories\BaseRepository;
use App\Models\Core\ShoppingCart as ShoppingCartModel;

class ShoppingCart extends BaseRepository {
    /**
     * ProductRepository constructor.
     * @param ShoppingCartModel $page
     */
    public function __construct(ShoppingCartModel $page) {
        $this->model = $page;
    }

    /**
     * @param string $clientIp
     * @param null $objUser
     * @return mixed
     */
    public function getUserCart(string $clientIp, $objUser = null){
        if (is_null($objUser)){
            $objCart = $this->model->where("user_ip", $clientIp)->where("status", "new")->first();
        } else {
            $objCart = $objUser->cart;
        }

        return ($objCart);
    }

    /**
     * @param string $paymentMethod
     * @return mixed
     */
    public function getCartByPaymentMethod(string $paymentMethod){
        $objCart = $this->model->where("payment_method", $paymentMethod)->first();

        return ($objCart);
    }

    /**
     * @param string $clientIp
     * @param null $objUser
     * @return mixed
     * @throws \Exception
     */
    public function createCart(string $clientIp, $objUser = null){
        if (is_null($objUser)){
            $objCart = $this->model->create([
                "row_uuid" => Util::uuid(),
                "user_ip"  => $clientIp,
                "status"   => "new"
            ]);
        } else {
            $objCart = $this->model->create([
                "row_uuid"  => Util::uuid(),
                "user_id"   => $objUser->user_id,
                "user_uuid" => $objUser->user_uuid,
                "status"    => "new"
            ]);
        }

        return ($objCart);
    }

    /**
     * @param string $paymentMethod
     * @param string $status
     */
    public function updateCart(string $paymentMethod, string $status){
        $this->model->where("payment_method", $paymentMethod)->update(["status" => ShoppingCartModel::$statuses[$status]]);
    }
}
