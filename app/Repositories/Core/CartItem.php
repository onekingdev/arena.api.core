<?php

namespace App\Repositories\Core;

use App\Repositories\BaseRepository;
use App\Models\Core\CartItem as CartItemModel;

class CartItem extends BaseRepository {
    /**
     * ProductRepository constructor.
     * @param CartItemModel $page
     */
    public function __construct(CartItemModel $page) {
        $this->model = $page;
    }
}
