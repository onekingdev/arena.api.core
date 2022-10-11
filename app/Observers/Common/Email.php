<?php

namespace App\Observers\Common;

use Auth;
use Util;
use App\Models\Users\Contact\UserContactEmail;

class Email {
    /**
     * @param UserContactEmail $objEmail
     * @return void
     */
    public function verified(UserContactEmail $objEmail) {
        $objEmail->flag_verified = true;
        $objEmail->{UserContactEmail::EMAIL_AT} = Util::now();
        $objEmail->{UserContactEmail::STAMP_EMAIL} = time();
        $objEmail->{UserContactEmail::STAMP_EMAIL_BY} = Auth::id();
        $objEmail->save();
    }
}
