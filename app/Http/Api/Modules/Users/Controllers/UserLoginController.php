<?php

namespace App\Http\Api\Modules\Users\Controllers;


use App\Exceptions\CustomValidationException;
use App\Http\Controllers\BaseController;
use App\Http\Api\Modules\Users\Interfaces\UserInterface;
use App\Http\Api\Modules\Users\Requests\UserLoginRequest;
use App\Http\Api\Modules\Users\Resources\UserResource;


class UserLoginController extends BaseController
{

    public function __construct(private UserInterface $userService)
    {
    }

    /**
     * Login for admin.
     *
     * @param UserLoginRequest $request Incoming request.
     *
     * @return UserResource
     * @throws CustomValidationException
     */
    public function login(UserLoginRequest $request): UserResource
    {
        $user = $this->userService->login($request->validated());

        return (new UserResource($user))->additional([
            'token' => $user->createToken($request->ip())->plainTextToken,
        ]);
    }
    public function logout(): void
    {
        $this->userService->UserLogout();
    }

}
