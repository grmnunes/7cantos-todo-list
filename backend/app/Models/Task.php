<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'title',
        'description',
        'status',
        'finished_at',
        'user_id',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope('owner', function (Builder $query) {
            if (auth()->hasUser()) {
                $query->where('user_id', auth()->user()->id);
            }
        });
    }
}
