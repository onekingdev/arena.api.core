<?php

namespace Tests\Unit;

use App\Models\Users\User;
use App\Services\User as UserService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserServiceTest extends TestCase
{

    /** @var UserService */
    private UserService $userService;

    public function __construct(?string $name = null, array $data = [], $dataName = "") {
        parent::__construct($name, $data, $dataName);
        $this->userService = app(UserService::class);
    }

    public function testCreate()
    {
        $user = $this->userService->create(
          array_merge(User::factory()->make()->toArray(), ["user_password" => "password"])
        );

        $this->assertInstanceOf(User::class, $user);

    }

    public function testFind()
    {

        $user = $this->userService->create(
            array_merge(User::factory()->make()->toArray(), ["user_password" => "password"])
        );

        $user = $user->refresh();

        $userFindInstance = $this->userService->find($user->user_id);

        $this->assertEquals(
            $user->toArray(),
            $userFindInstance->toArray()
        );

    }

    public function testDelete()
    {
        $this->expectException(ModelNotFoundException::class);
        $user = User::factory()->create();

        $this->userService->delete($user->user_id);
        $this->userService->find($user->user_id, true);
    }

}
