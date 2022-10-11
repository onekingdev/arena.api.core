<?php

namespace App\Http\Transformers\Soundblock;

use Util;
use App\Traits\StampCache;
use App\Http\Transformers\User\User;
use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Accounts\AccountNote as AccountNoteModel;

class AccountNote extends BaseTransformer
{
    use StampCache;

    public function transform(AccountNoteModel $objNote)
    {
        $response = [
            "note_uuid" => $objNote->note_uuid,
            "account_uuid" => $objNote->account_uuid,
            "account_notes" => $objNote->account_notes,
            "user" => [
                "data" => [
                    "user_uuid" => $objNote->user->user_uuid,
                    "avatar_url" => Util::avatar_url($objNote->user),
                    "name_first" => $objNote->user->name_first,
                    "name_middle" => $objNote->user->name_middle,
                    "name_last" => $objNote->user->name_last,
                ]
            ],
        ];

        return(array_merge($response, $this->stamp($objNote)));
    }

    public function includeAttachments(AccountNoteModel $objNote)
    {
        return($this->collection($objNote->attachments, new AccountNoteAttachment));
    }

    public function includeUser(AccountNoteModel $objNote)
    {
        return($this->item($objNote->user, new User(["avatar"])));
    }
}
