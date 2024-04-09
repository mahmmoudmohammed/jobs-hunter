<?php

namespace App\Http\Api\Modules\Jobs\Policies;

use App\Http\Api\Modules\Users\Models\Admin;
use Illuminate\Auth\Access\HandlesAuthorization;
class JobPolicy
{
    use HandlesAuthorization;

    public function create($user)
    {
        return $user->role->name == 'administrator';
    }
}
