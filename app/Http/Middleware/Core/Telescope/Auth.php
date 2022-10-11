<?php

namespace App\Http\Middleware\Core\Telescope;

use Closure;

class Auth {
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        if (!$request->is(["telescope", "telescope/*"])) {
            abort(400, "Invalid Request URI.");
        }

        if (session()->has("TELESCOPE_AUTH") && session("TELESCOPE_AUTH") === env("TELESCOPE_AUTH_TOKEN")) {
            return $next($request);
        }

        if (!$request->has("telescope_token")) {
            abort(401, "Auth Token Has Not Provided.");
        }

        if ($request->input("telescope_token") !== env("TELESCOPE_AUTH_TOKEN")) {
            abort(401, "Auth Token Mismatch.");
        }

        session()->put("TELESCOPE_AUTH", env("TELESCOPE_AUTH_TOKEN"));

        return $next($request);
    }
}
