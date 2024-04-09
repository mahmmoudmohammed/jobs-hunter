<?php

namespace App\Http\Api\Modules\Roles\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory, SoftDeletes;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'userable_type',
        'userable_id',
    ];
    protected $hidden = [
        'id'
    ];

    public function userable(): BelongsTo
    {
        return $this->morphTo();
    }
}
