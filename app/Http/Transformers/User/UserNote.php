<?php

namespace App\Http\Transformers\User;

use App\Http\Transformers\BaseTransformer;
use App\Models\Users\UserNote as UserNoteModel;
use App\Traits\StampCache;

class UserNote extends BaseTransformer
{

    use StampCache;

    public function transform(UserNoteModel $objNote)
    {
        $response = [
            "note_uuid" => $objNote->note_uuid,
            "user_notes" => $objNote->user_notes,
            "stamp_created_by_avatar" => $objNote->createdBy->avatar
        ];
        $response = array_merge($response, $this->stamp($objNote));

        return($response);
    }

    public function includeAttachments(UserNoteModel $objNote)
    {
        return($this->collection($objNote->attachments, new UserNoteAttachment));
    }
}
