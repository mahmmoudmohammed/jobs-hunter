<?php

declare(strict_types=1);

namespace App\Http\Api\Modules\Users;

use App\Http\Api\Modules\Users\Interfaces\AdminInterface;
use App\Http\Api\Modules\Users\Interfaces\UserInterface;
use App\Http\Api\Modules\Users\Models\User;
use App\Http\Api\Modules\Users\Policies\UserPolicy;
use App\Http\Api\Modules\Users\Repositories\AdminRepository;
use App\Http\Api\Modules\Users\Repositories\UserRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class UserServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */

    public function register()
    {
        //TODO::bind interface repositories
        $this->app->bind( UserInterface::class, UserRepository::class);
        $this->app->bind( AdminInterface::class, AdminRepository::class);
    }

    public function boot()
    {
        Gate::policy(User::class, UserPolicy::class);

        // TODO::boot any observers
    }
}
