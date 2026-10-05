<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use SoftDeletes; // Mengaktifkan Soft Deletes

    protected $fillable = [
        'title',
        'description',
        'status',
    ];

    // Local Scope untuk memfilter post dengan status 'published'
    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }
}