<?php

namespace App\Models\Support\Ticket;

use App\Models\BaseModel;
use App\Models\Users\User;
use App\Models\Support\Support;
use App\Models\Core\Auth\AuthGroup;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

/**
 * @property-read User $user
 */
class SupportTicket extends BaseModel {
    use SoftDeletes;
    use HasFactory;

    protected $table = "support_tickets";

    protected $primaryKey = "ticket_id";

    protected string $uuid = "ticket_uuid";

    protected $hidden = [
        "ticket_id", "support_id", "user_id",
        BaseModel::CREATED_AT, BaseModel::UPDATED_AT,
        BaseModel::DELETED_AT, BaseModel::STAMP_DELETED, BaseModel::STAMP_DELETED_BY,
    ];

    protected $guarded = [];

    public $metaData = [
        "filters" => [
            "ticket_status" => [
                "column" => "flag_status"
            ],
            "user_uuid" => [
                "column" => "user_uuid"
            ],
            "support_category" => [
                "relation" => "support",
                "relation_table" => "support",
                "column" => "support_category"
            ],
            "app_name" => [
                "relation" => [
                    "support",
                    "app"
                ],
                "relation_table" => "core_apps",
                "column" => "app_name"
            ]
        ],
        "search" => [
            "ticket_title" => [
                "column" => "ticket_title"
            ],
        ],
        "sort" => [
            "ticket_title" => [
                "column" => "ticket_title"
            ],
            "ticket_status" => [
                "column" => "flag_status"
            ],
            "created" => [
                "column" => "stamp_created"
            ],
            "app_name" => [
                "relation_table" => "core_apps",
                "column" => "app_name"
            ],
            "support_category" => [
                "relation_table" => "support",
                "column" => "support_category"
            ],
        ],
    ];

    public function support() {
        return ($this->belongsTo(Support::class, "support_id", "support_id"));
    }

    public function user() {
        return ($this->belongsTo(User::class, "user_id", "user_id"));
    }

    public function messages() {
        return ($this->hasMany(SupportTicketMessage::class, "ticket_id", "ticket_id"));
    }

    public function attachments() {
        return ($this->hasMany(SupportTicketAttachment::class, "ticket_id", "ticket_id"));
    }

    public function supportUser() {
        return $this->belongsToMany(User::class, "support_tickets_users", "ticket_id", "user_id");
    }

    public function supportGroup() {
        return $this->belongsToMany(AuthGroup::class, "support_tickets_groups", "ticket_id", "group_id");
    }
}
