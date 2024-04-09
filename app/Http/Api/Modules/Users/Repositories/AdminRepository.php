<?php

namespace App\Http\Api\Modules\Users\Repositories;

use App\Exceptions\CustomValidationException;
use App\Http\Api\Modules\BaseRepository;
use App\Http\Api\Modules\Users\Interfaces\AdminInterface;
use App\Http\Api\Modules\Users\Models\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class AdminRepository extends BaseRepository implements AdminInterface
{
    protected function model(): string
    {
        return Admin::class;
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
    public function adminLogout(): void
    {
        parent::logout('admin');
    }
}
