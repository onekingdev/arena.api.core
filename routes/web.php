<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
/**
 * Test a notificaiton
 */
Route::get("/check", "Core\Notification@check");
Route::group(["prefix" => "2fa", "namespace" => "Core\Auth", "middleware" => ["set.header", "auth:api"]], function () {
    Route::get("/", "LoginSecurity@show2faForm");
    Route::post("/generate", "LoginSecurity@generate2faSecret")->name("generate");
    Route::post("/enable", "LoginSecurity@enable2fa")->name("enable");
    Route::post("/disable", "LoginSecurity@disable2fa")->name("disable");

    Route::post("/verify", function() {
        return(redirect(URL()->previous()));
    })->name("verify")->middleware("2fa");
});

Route::get("/test-middleware", function () {
    return("2FA middleware work!");
})->middleware(["set.header", "auth:api", "2fa"]);

Route::get("/mail/soundblock", function () {
    return view("mail.soundblock.invite");
});

Route::get("/mail/arena", function () {
    return view("mail.arena.signin");
});

Route::get("/mail/apparel", function () {
    return view("mail.apparel.tourmask");
});

Route::get("/mail/core", function () {
    return view("mail.core.correspondence");
});

Route::get("/mask", function () {
    return view("tourmask");
});
Route::get("/apparel", function () {
    return view("apparel");
});
