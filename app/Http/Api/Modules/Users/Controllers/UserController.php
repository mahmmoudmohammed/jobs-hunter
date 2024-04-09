<?php

namespace App\Http\Api\Modules\Users\Controllers;


use App\Http\Controllers\BaseController;
use App\Http\Api\Modules\Users\Interfaces\UserInterface;
use App\Http\Api\Modules\Users\Models\User;
use App\Http\Api\Modules\Users\Resources\UserResource;
use Illuminate\Http\JsonResponse;


class UserController extends BaseController
{
    private $userService;

    public function __construct(UserInterface $user)
    {
        $this->userService = $user;
    }

    public function getById(User $model): JsonResponse
    {
        $user = $this->userService->getById($model->id);
        if (!$user)
            return $this->error(__('common.not_found'),404);

        return  $this->responseResource(
            UserResource::make($user),
        );
    }
    public function delete(User $model): JsonResponse
    {
        $this->authorize('delete', $model);

        $deleted =$this->userService->delete($model->id);
        if(1 > $deleted)
            return $this->error(__('common.not_found'),404);

        if(!$deleted)
            return $this->error(__('common.error'),500);

        return $this->success();
    }
}
