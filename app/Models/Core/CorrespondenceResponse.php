<?php

namespace App\Models\Core;

use App\Models\BaseModel;

class CorrespondenceResponse extends BaseModel
{
    const UUID = "row_uuid";

    protected $primaryKey = "row_id";

    protected $table = "core_correspondence_responses";

    protected $guarded = [];

    protected string $uuid = "row_uuid";

    protected $hidden = [
        "row_id", "correspondence_uuid", BaseModel::DELETED_AT,  BaseModel::STAMP_DELETED,
        BaseModel::STAMP_DELETED_BY, BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
    ];

    public function correspondence(){
        return $this->belongsTo(Correspondence::class);
    }

    public function getAttachmentsPathAttribute(){
        return (bucket_storage("core")->path("public/correspondence/responses/attachments/" . $this->row_uuid));
    }
}
