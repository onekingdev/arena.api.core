<?php

namespace App\Http\Transformers\User;

use App\Http\Transformers\BaseTransformer;
use App\Models\Users\UserNoteAttachment as UserNoteAttachmentModel;
use App\Traits\StampCache;

class UserNoteAttachment extends BaseTransformer
{

    use StampCache;

    public function transform(UserNoteAttachmentModel $objAttach)
    {
        $response = [
            "attachment_url" => $objAttach->attachment_url,
        ];
        $response = array_merge($response, $this->stamp($objAttach));

        return($response);
    }
}
