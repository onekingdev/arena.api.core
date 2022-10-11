<?php

namespace App\Http\Transformers\Soundblock;

use App\Traits\StampCache;
use App\Http\Transformers\User\User;
use App\Http\Transformers\BaseTransformer;
use App\Models\Soundblock\Projects\ProjectNote as ProjectNoteModel;

class ProjectNote extends BaseTransformer
{

    use StampCache;

    public function transform(ProjectNoteModel $objNote)
    {
        $response = [
            "note_uuid" => $objNote->note_uuid,
            "project_uuid" => $objNote->project_uuid,
            "project_notes" => $objNote->project_notes,
        ];

        return(array_merge($response, $this->stamp($objNote)));
    }

    public function includeAttachments(ProjectNoteModel $objNote)
    {
        return($this->collection($objNote->attachments, new ProjectNoteAttachment));
    }

    public function includeUser(ProjectNoteModel $objNote)
    {
        return($this->item($objNote->user, new User(["avatar"])));
    }
}
