<?php

namespace App\Http\Api\Modules\Users\Interfaces;

use App\Http\Api\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Model;

interface UserInterface
{
    public function register($data): Model|bool;

    public function UserLogout(): void;

}
