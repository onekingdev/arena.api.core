<?php

namespace App\Models\Core\Mailing;

use App\Models\BaseModel;

class Email extends BaseModel
{
    const UUID = "row_uuid";

    protected $primaryKey = "row_id";

    protected $table = "core_mailing_emails";

    protected $guarded = [];

    protected string $uuid = "row_uuid";

    protected $hidden = [
        "row_id", BaseModel::DELETED_AT,  BaseModel::STAMP_DELETED,
        BaseModel::STAMP_DELETED_BY, BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
    ];
}
