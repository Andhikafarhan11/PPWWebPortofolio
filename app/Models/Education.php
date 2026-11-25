<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Education extends Model
{
    protected $table = 'educations';

    protected $fillable = ['institution', 'degree', 'period', 'description'];

    protected static function booted(): void
    {
        static::saved(fn () => Cache::forget('portfolio.educations'));
        static::deleted(fn () => Cache::forget('portfolio.educations'));
    }
}