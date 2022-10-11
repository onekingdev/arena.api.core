<?php

namespace App\Models\Core;

use App\Models\BaseModel;

class CartItem extends BaseModel
{
    const UUID = "row_uuid";

    protected $primaryKey = "row_id";

    protected $table = "core_cart_items";

    protected $guarded = [];

    protected string $uuid = "row_uuid";

    protected $hidden = [
        "row_id", "model_id", "cart_id", BaseModel::DELETED_AT,  BaseModel::STAMP_DELETED,
        BaseModel::STAMP_DELETED_BY, BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
    ];

    public function item(){
        return $this->morphTo("item", "model_class", "model_id");
    }

    public function cart(){
        return $this->belongsTo(ShoppingCart::class);
    }
}
