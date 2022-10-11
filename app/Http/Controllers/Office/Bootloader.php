<?php

namespace App\Http\Controllers\Office;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

/**
 * @group Office Soundblock
 *
 */
class Bootloader extends Controller
{
    /**
     * @return mixed
     */
    public function getAuthUserGroup(){
        $objUser = Auth::user();

        return ($this->apiReply($objUser->groups, "User groups", 200));
    }
}
