<?php

namespace App\Http\Transformers\Soundblock;

use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Projects\ProjectNoteAttachment as ProjectNoteAttachmentModel;
use App\Traits\StampCache;

class ProjectNoteAttachment extends BaseTransformer
{

    use StampCache;

    public function transform(ProjectNoteAttachmentModel $objAttach)
    {
        $response = [
            "attachment_url" => $objAttach->attachment_url,
        ];

        return(array_merge($response, $this->stamp($objAttach)));
    }
}
