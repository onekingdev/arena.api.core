<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Accounts\AccountNoteAttachment as AccountNoteAttachmentModel;

class AccountNoteAttachment extends BaseTransformer
{
    use StampCache;

    public function transform(AccountNoteAttachmentModel $objAttach)
    {
        $response = [
            "attachment_uuid" => $objAttach->row_uuid,
            "attachment_url" => $objAttach->attachment_url,
        ];

        return(array_merge($response, $this->stamp($objAttach)));
    }
}
