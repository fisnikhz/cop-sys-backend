<?php

namespace Tests\Unit;

use App\Http\Controllers\API\V1\UserController;
use App\Http\Requests\API\V1\Auth\ChangePasswordRequest;
use App\Http\Requests\API\V1\Auth\LoginRequest;
use App\Http\Requests\API\V1\Auth\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mockery;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new UserController();
    }

    /** @test */
    public function it_can_login()
    {
        $request = Mockery::mock(LoginRequest::class);
        $request->shouldReceive('username')->andReturn('test_username');
        $request->shouldReceive('password')->andReturn('test_password');

        $user = new User([
            'username' => 'test_username',
            'password' => Hash::make('test_password' . 'test_salt'),
            'salt' => 'test_salt',
        ]);

        User::shouldReceive('query->where->first')->with('username', 'test_username')->once()->andReturn($user);
        Hash::shouldReceive('check')->with('test_password' . 'test_salt', $user->password)->andReturn(true);

        $response = $this->controller->login($request);

        $this->assertInstanceOf(JsonResponse::class, $response);
        $this->assertEquals(200, $response->status());
    }

}
