<?php

namespace Tests\Feature;

use App\Models\Users\User;
use App\Models\Users\Contact\UserContactEmail;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    //TODO: Fix Auth Test

    public function testExample() {
        $this->assertTrue(true);
    }

//    public function testSignInOut()
//    {
//
//        $user = factory(User::class)->create();
//        $user->each(function ($objUser) {
//            $objUser->emails()->save(factory(UserEmail::class)->make([
//                "user_uuid" => $objUser->user_uuid,
//                "flag_primary" => true
//            ]));
//        });
//        $user->save();
//
//        // Login
//        $_SERVER["HTTP_X_API"] = "v1.0";
//        $_SERVER["HTTP_X_API_HOST"] = "app.arena.arena.web";
//
//        $response = $this->json("POST", '/auth/signin', [
//            'user' => $user->emails()->value("user_auth_email"),
//            'password' => 'password'
//        ]);
//        dd($response->getContent());
//        $response->assertStatus(200);
//        $token = json_decode($response->getContent(), true)['data']['token'];
//        // Get the token. Query self.
//        $this->refreshApplication();
//        $selfQueryResponse = $this->get('/auth/user', [
//            'Authorization' => 'Bearer ' . $token,
//        ]);
//        $selfQueryResponse->assertStatus(200);
//        // Refresh token
//        $this->refreshApplication();
//        $tokenRefreshResponse = $this->patch('/auth/refresh', [
//            //
//        ], [
//            'Authorization' => 'Bearer ' . $token,
//        ]);
//        $tokenRefreshResponse->assertStatus(200);
//        $this->refreshApplication();
//        // Logout
//        $logoutResponse = $this->delete('/auth/invalidate', [], [
//            'Authorization' => 'Bearer ' . $token,
//        ]);
//        $logoutResponse->assertStatus(200);
//        // Now you cannot query yourself
//        $this->refreshApplication();
//        $loggedOutTestQuery = $this->get('/auth/user');
//        $loggedOutTestQuery->assertStatus(401);
//
//    }

}
