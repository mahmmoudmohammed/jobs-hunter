<?php

namespace App\Http\Api\Modules\Users\Controllers;


use App\Http\Api\Modules\Users\Requests\RegisterAdminRequest;
use App\Http\Controllers\BaseController;
use App\Http\Api\Modules\Users\Interfaces\UserInterface;
use App\Http\Api\Modules\Users\Resources\UserResource;
use App\Support\OTP;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;


class AdminRegisterController extends BaseController
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

    public function register(RegisterAdminRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->register($request->validated());
            $this->userService->sendEmailOTP('user',$user);

            return $this->responseResource(UserResource::make($user), [
                'token' => $user->createToken($request->ip())->plainTextToken,
            ]);
        } catch (\Throwable $exception) {
            report($exception);
            return $this->error(__('common.error'));
        }
    }
    public function verifyEmail(Request $request): JsonResponse
    {
        $request->validate([
            'otp_code' => ['required', 'digits:6'],
        ]);

        $user = auth()->user();
        if (!OTP::check('user', $user->email, $request->otp_code)) {
            return $this->error(__('errors.invalid_otp'));
        }

        $user->email_verified_at = now();
        $user->is_active = true;
        $user->save();

        return $this->success();
    }
}
