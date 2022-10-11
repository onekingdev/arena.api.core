<?php

namespace App\Models\Core;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ShoppingCart extends BaseModel
{
    use HasFactory;

    const UUID = "row_uuid";

    protected $primaryKey = "row_id";

    protected $table = "core_shopping_carts";

    protected $guarded = [];

    protected string $uuid = "row_uuid";

    protected $hidden = [
        "row_id", "user_id", "user_ip", BaseModel::DELETED_AT,  BaseModel::STAMP_DELETED,
        BaseModel::STAMP_DELETED_BY, BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
    ];

    public static $statuses = [
        "charge.new" => "new",
        "charge.succeeded" => "succeeded",
        "charge.refunded" => "refunded"
    ];

    public function items(){
        return $this->hasMany(CartItem::class, "cart_id", "row_id");
    }
}
