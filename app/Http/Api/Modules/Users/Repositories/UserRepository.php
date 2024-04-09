<?php

namespace App\Http\Api\Modules\Users\Repositories;

use App\Exceptions\CustomValidationException;
use App\Http\Api\Modules\BaseRepository;
use App\Http\Api\Modules\Users\Interfaces\UserInterface;
use App\Http\Api\Modules\Users\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use Illuminate\Database\Eloquent\Model;

class UserRepository extends BaseRepository implements UserInterface
{
    protected function model(): string
    {
        return User::class;
    }

    public function register($data): Model|bool
    {
        return $this->create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password'])
        ]);
    }

    /**
     * @param array $data
     * @return Model
     * @throws CustomValidationException
     */
    public function login(array $data): Model
    {
        if (isset($data['phone']))
            $user = $this->phoneLogin($data);
        else
            $user = $this->mailLogin($data);

        return $user;
    }

    /**
     * @throws CustomValidationException
     */
    public function UserLogout(): void
    {
        parent::logout();
    }
}
