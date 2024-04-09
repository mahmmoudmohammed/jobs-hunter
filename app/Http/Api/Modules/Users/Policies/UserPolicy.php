<?php

namespace App\Http\Api\Modules\Users\Policies;

use App\Http\Api\Modules\Users\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;
    public function delete($user,User $model)
    {
        return  $user->role == 'administrator'|| $user->id == $model->id;
    }
}
