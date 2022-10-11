<?php

namespace App\Http\Controllers\Core;

use Auth;
use Cache;
use App\Models\Core\App;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;

/**
 * @group Core
 *
 */
class Server extends Controller {

    public function ping() {
        return ($this->apiReply());
    }

    public function get() {
        return ($this->apiReply(App::all()));
    }

    public function version() {
        if (file_exists(base_path("version"))) {
            return ($this->apiReply(file_get_contents(base_path("version"))));
        }

        return ($this->apiReply("develop", "", 400));
    }

    public function flushCache(){
        if (!is_authorized(Auth::user(), "Arena.Developers", "Arena.Developers.Default")) {
            return $this->apiReject("", "You don't have required permissions.", Response::HTTP_FORBIDDEN);
        }

        Cache::flush();

        return ($this->apiReply(null, "Cache flushed successfully.", Response::HTTP_OK));
    }
}
