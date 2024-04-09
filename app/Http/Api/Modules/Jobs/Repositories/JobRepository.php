<?php

namespace App\Http\Api\Modules\Jobs\Repositories;

use App\Http\Api\Modules\BaseRepository;
use App\Http\Api\Modules\Jobs\Interfaces\JobInterface;
use App\Http\Api\Modules\Jobs\Models\Job;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

class JobRepository extends BaseRepository implements JobInterface
{
    protected function model(): string
    {
        return Job::class;
    }

    /**
     * @return false|LengthAwarePaginator
     */
    public function list(): LengthAwarePaginator|false
    {
        return Job::with('creator')->latest()
            ->paginate($this::paginationLimit(request('per_page', config('app.pagination'))));
    }

    public function create($data): bool|Model
    {
        $data['user_id'] = auth()->user()->id ?: $data['user_id'];
        $job = parent::create($data);
        return !$job ? false : $job->load('creator');
    }

}
