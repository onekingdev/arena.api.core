<?php

namespace App\Models\Support\Ticket;

use App\Models\BaseModel;
use App\Models\Users\User;
use Illuminate\Database\Eloquent\SoftDeletes;

class SupportTicketMessage extends BaseModel {
    use SoftDeletes;

    protected $table = "support_tickets_messages";

    protected $primaryKey = "message_id";

    protected string $uuid = "message_uuid";

    protected $hidden = [
        "message_id", "ticket_id", "user_id",
        BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];

    protected $guarded = [];

    public $metaData = [
        "filters" => [
            "user_uuid" => [
                "column" => "user_uuid"
            ],
            "flag_attachments" => [
                "column" => "flag_attachments"
            ],
            "flag_notified" => [
                "column" => "flag_notified"
            ],
            "flag_office" => [
                "column" => "flag_office"
            ],
            "flag_officeonly" => [
                "column" => "flag_officeonly"
            ],
            "flag_status" => [
                "column" => "flag_status"
            ],
        ],
        "search" => [
            "message_text" => [
                "column" => "message_text"
            ],
        ],
        "sort" => [
            "flag_attachments" => [
                "column" => "flag_attachments"
            ],
            "flag_notified" => [
                "column" => "flag_notified"
            ],
            "flag_office" => [
                "column" => "flag_office"
            ],
            "flag_officeonly" => [
                "column" => "flag_officeonly"
            ],
            "flag_status" => [
                "column" => "flag_status"
            ],
            "created" => [
                "column" => "stamp_created"
            ]
        ],
    ];

    public function ticket() {
        return ($this->belongsTo(SupportTicket::class, "ticket_id", "ticket_id"));
    }

    public function user() {
        return ($this->belongsTo(User::class, "user_id", "user_id"));
    }

    public function attachments() {
        return ($this->hasMany(SupportTicketAttachment::class, "message_id", "message_id"));
    }
}
