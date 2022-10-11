<?php

namespace App\Repositories\Core\Mailing;

use App\Models\Core\Mailing\Email as MailingEmailModel;
use App\Repositories\BaseRepository;

class Emails extends BaseRepository {

    public function __construct(MailingEmailModel $email) {
        $this->model = $email;
    }

    public function deleteByUuid(string $emailUuid){
        $boolResult = $this->model->where("row_uuid", $emailUuid)->delete();

        return ($boolResult);
    }
}
