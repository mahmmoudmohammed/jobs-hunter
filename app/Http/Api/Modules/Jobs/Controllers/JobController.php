<?php

namespace App\Http\Api\Modules\Jobs\Controllers;

use App\Http\Api\Modules\Jobs\Interfaces\JobInterface;
use App\Http\Api\Modules\Jobs\Requests\ApplyJobRequest;
use App\Http\Api\Modules\Jobs\Requests\CreateJobRequest;
use App\Http\Api\Modules\Jobs\Resources\JobResource;
use App\Http\Api\Modules\Jobs\Models\Job;
use App\Http\Controllers\BaseController;
use Illuminate\Http\JsonResponse;


class JobController extends BaseController
{
    public function __construct(private JobInterface $jobService)
    {
    }
    public function timeline(): JsonResponse
    {
        $models = $this->jobService->list();
        if (!$models)
            return $this->error(__('common.not_found'),203);

        return $this->responseResource(
            JobResource::collection($models)
        );
    }
    public function getById(Job $model): JsonResponse
    {
        $user = $this->jobService->getById($model->id);
        if (!$user)
            return $this->error(__('common.not_found'),404);

        return  $this->responseResource(
            JobResource::make($user),
        );
    }

    public function create(CreateJobRequest $request): JsonResponse
    {
        $this->authorize('create',Job::class);

        $job = $this->jobService->create($request->validated());
        if (!$job)
            return $this->error(__('common.error'), 500);
        return $this->responseResource(
            JobResource::make($job),
            status: 201
        );
    }


    public function apply(Job $job): JsonResponse
    {
        auth()->user()->applications()->syncWithoutDetaching($job);
        return $this->success();
    }

}
