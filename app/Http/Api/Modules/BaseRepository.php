<?php

namespace App\Http\Api\Modules;

use App\Exceptions\CustomValidationException;
use App\Http\Api\Traits\ApiDesignTrait;
use App\Jobs\SendEmailVerificationJob;
use App\Support\OTP;
use Illuminate\Auth\Events\Logout;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

abstract  class BaseRepository
{
    use ApiDesignTrait;
    protected abstract function model ():string|Model;

    /**
     * @throws CustomValidationException
     */
    protected function mailLogin(array $data): Model
    {
        $user = $this->model()::whereEmail($data['email'])->first();

        if (!$user || !Hash::check($data['password'], $user->password))
            $this->throwValidationException(__('auth.failed'));
        if (!$user->is_active)
            $this->throwValidationException(__('auth.in_active'));
        if (!$user->email_verified_at)
            $this->throwValidationException(__('auth.email_not_verified'));

        return $user;
    }
    /**
     * @throws CustomValidationException
     */
    protected function phoneLogin(array $data): Model
    {
        $user = $this->model()::where('phone', 'like', '%'.$data['phone'].'%')->first();

        if (!$user || !Hash::check($data['password'], $user->password))
            $this->throwValidationException(__('auth.failed'));
        if (!$user->is_active)
            $this->throwValidationException(__('auth.in_active'));
        if (!$user->email_verified_at)
            $this->throwValidationException(__('auth.email_not_verified'));

        return $user;
    }

    /**
     * @throws CustomValidationException
     */
    protected function logout(string $guard = null): void
    {
        try {
            $user = auth($guard)->user();
            $user->currentAccessToken()->delete();
            event(new Logout($guard, $user));
        } catch (\Exception $e) {
            logger("Exception Error: while trying to logout in:".PHP_EOL." File".__FILE__ . " (Line: " . __LINE__ . ") ".PHP_EOL." {$e->getMessage()}");
            throw new CustomValidationException(__('error.logout_error'));
        }
    }
    public function create(array $data):model|bool
    {
        try {
            return $this->model()::create($data);
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }


    public function getById(int $id): model|bool
    {
        try {
            return $this->model()::where('id', $id)->first()?:false;
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    public function update(int $id, array $data): Model|bool
    {
        try {
            $model = $this->model()::findOrFail($id);
            $model->update($data);
            return $model->refresh();
        }
        catch (\Exception $e) {
            report($e);
            return false;
        }
    }

    public function delete(int $id): int|bool
    {
        try {
            return $this->model()::where('id', $id)->delete();
        } catch (\Exception $e) {
            report($e);
            return false;
        }
    }
    public static function paginationLimit($perPage, $minPerPage = 5, $maxPerPage = 100)
    {
        $perPage ??= 15;
        return max($minPerPage, min($maxPerPage, $perPage));
    }
    public function sendEmailOTP(string $key, $user): void
    {
        if (!$user->email) {
            return;
        }
        $otpCode = OTP::generate($key, $user->email)['otpCode'] ?? '';
        SendEmailVerificationJob::dispatch($user, $otpCode);
    }

}
