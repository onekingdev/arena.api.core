<?php

namespace App\Repositories\Common;

use App\Repositories\BaseRepository;
use App\Models\Soundblock\Accounts\AccountNoteAttachment as AccountNoteAttachmentModel;

class AccountNoteAttachment extends BaseRepository {
    public function __construct(AccountNoteAttachmentModel $objAttach) {
        $this->model = $objAttach;
    }
}
