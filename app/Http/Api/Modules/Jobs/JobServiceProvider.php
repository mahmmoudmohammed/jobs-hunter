<?php

declare(strict_types=1);

namespace App\Http\Api\Modules\Jobs;

use App\Http\Api\Modules\Jobs\Interfaces\JobInterface;
use App\Http\Api\Modules\Jobs\Models\Job;
use App\Http\Api\Modules\Jobs\Policies\JobPolicy;
use App\Http\Api\Modules\Jobs\Repositories\JobRepository;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class JobServiceProvider extends ServiceProvider
{

    public function register()
    {
        //TODO::bind interface repositories
        $this->app->bind(JobInterface::class, JobRepository::class);
    }

    public function boot()
    {
        Gate::policy(Job::class, JobPolicy::class);
        // TODO::boot any observers
    }
}
