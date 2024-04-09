<?php

namespace App\Http\Api\Modules\Users\Models;

use App\Http\Api\Modules\Jobs\Models\Job;
use App\Http\Api\Modules\Roles\Models\Role;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;

class User extends Authenticatable
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
    public function applications(): BelongsToMany
    {
        return $this->belongsToMany(Job::class, 'user_vacancies', 'user_id', 'vacancy_id');
    }

    public function role(): MorphOne
    {
        return $this->morphOne(Role::class, 'userable');
    }

}
