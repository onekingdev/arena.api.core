<?php

namespace App\Models\Soundblock\Accounts;

use App\Models\BaseModel;
use App\Models\Users\User;

class AccountNote extends BaseModel
{
    protected $table = "soundblock_accounts_notes";

    protected $primaryKey = "note_id";

    protected string $uuid = "note_uuid";

    protected $hidden = [
        "note_id", "account_id", "account_uuid",
        BaseModel::CREATED_AT, BaseModel::UPDATED_AT, BaseModel::DELETED_AT,
        BaseModel::STAMP_CREATED_BY, BaseModel::STAMP_UPDATED_BY, BaseModel::STAMP_DELETED_BY
    ];

    protected $guarded = [];

    public $metaData = [
        "filters" => [
            "account" => [
                "relation" => "account",
                "relation_table" => "soundblock_accounts",
                "column" => "account_uuid"
            ],
            "user" => [
                "relation" => "user",
                "relation_table" => "users",
                "column" => "user_uuid"
            ]
        ],
        "search" => [],
        "sort" => [
            "created" => [
                "column" => "stamp_created"
            ],
        ]
    ];

    public function attachments()
    {
        return($this->hasMany(AccountNoteAttachment::class, "note_id", "note_id"));
    }

    public function account()
    {
        return($this->belongsTo(Account::class, "account_id", "account_id"));
    }

    public function user()
    {
        return($this->belongsTo(User::class, "user_id", "user_id"));
    }
}
