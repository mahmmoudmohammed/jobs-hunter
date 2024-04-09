<?php

namespace App\Http\Api\Modules\Users\Models;

use App\Http\Api\Modules\Jobs\Models\Job;
use App\Http\Api\Modules\Roles\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'username',
        'email',
        'password',
        'is_active',
        'email_verified_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'email_verified_at' => 'datetime',
    ];

    protected $hidden = [
        'id', 'password'
    ];

    public function postedJobs(): HasMany
    {
        return $this->hasMany(Job::class);
    }
    public function role(): MorphOne
    {
        return $this->morphOne(Role::class, 'userable');
    }
}
