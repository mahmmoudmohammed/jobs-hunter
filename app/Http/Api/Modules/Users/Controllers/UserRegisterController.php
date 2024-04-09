<?php

namespace App\Http\Api\Modules\Users\Controllers;


use App\Http\Controllers\BaseController;
use App\Http\Api\Modules\Users\Interfaces\UserInterface;
use App\Http\Api\Modules\Users\Requests\UserRegistrationRequest;
use App\Http\Api\Modules\Users\Resources\UserResource;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Throwable;


class UserRegisterController extends BaseController
{
    private $userService;

    public function __construct(UserInterface $user)
    {
        $this->userService = $user;
    }

    /**
     * store new User in db and create Auth token
     *
     * @param mixed $request
     *
     * @return JsonResponse
     */
    public function register(UserRegistrationRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->register($request->validated());
            $this->userService->sendEmailOTP('user',$user);

            return $this->responseResource(UserResource::make($user), [
                'token' => $user->createToken($request->ip())->plainTextToken,
            ]);
        } catch (Throwable $exception) {
            report($exception);
            return $this->error(__('common.error'));
        }
    }
}
