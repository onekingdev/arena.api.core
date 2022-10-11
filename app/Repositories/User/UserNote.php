<?php

namespace App\Repositories\User;

use App\Models\Users\UserNote as UserNoteModel;
use App\Repositories\BaseRepository;

class UserNote extends BaseRepository {
    public function __construct(UserNoteModel $objNote) {
        $this->model = $objNote;
    }
}
