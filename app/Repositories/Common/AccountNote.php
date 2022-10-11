<?php

namespace App\Repositories\Common;

use App\Repositories\BaseRepository;
use App\Models\Soundblock\Accounts\AccountNote as AccountNoteModel;

class AccountNote extends BaseRepository {
    /**
     * @param AccountNoteModel $accountNote
     * @return void
     */
    public function __construct(AccountNoteModel $accountNote) {
        $this->model = $accountNote;
    }

    public function findAll(array $arrData, int $per_page = 10){
        [$query, $availableMetaData] = $this->applyMetaFilters($arrData);

        return ([$query->paginate($per_page), $availableMetaData]);
    }
}
