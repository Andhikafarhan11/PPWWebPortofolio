<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Experience extends Model
{
    protected $fillable = ['title', 'company', 'period', 'description'];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('portfolio.experiences'));
        static::deleted(fn () => Cache::forget('portfolio.experiences'));
    }
}