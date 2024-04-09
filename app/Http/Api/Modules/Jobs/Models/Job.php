<?php

namespace App\Http\Api\Modules\Jobs\Models;

use App\Http\Api\Modules\Users\Models\Admin;
use App\Http\Api\Modules\Users\Models\User;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;
    protected $table = 'vacancies';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title','description','user_id'
    ];
    protected $casts = [
    ];
    protected $hidden = [
        'id'
    ];
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'user_vacancies', 'vacancy_id', 'user_id');
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(Admin::class);
    }
    public function role(): BelongsTo
    {
        return $this->belongsTo(Role::class);
    }
}
