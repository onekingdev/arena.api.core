<?php

namespace App\Repositories\User;

use App\Models\Users\Contact\UserContactPostal;
use App\Repositories\BaseRepository;

class Postal extends BaseRepository {
    public function __construct(UserContactPostal $objPostal) {
        $this->model = $objPostal;
    }
}
