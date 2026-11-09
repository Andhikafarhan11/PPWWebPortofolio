<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
    'judul',
    'thumbnail', // Wajib ditambahkan agar path tersimpan
    'kategori',
    'deskripsi',
    'tautan',
    'status',
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }


    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if ($term) {
            return $query->where('judul', 'like', '%' . $term . '%');
        }

        return $query;
    }
    
    public function category()
    {
    return $this->belongsTo(Category::class);
    }

    public function technologies()
    {
    return $this->belongsToMany(Technology::class);
    }

    public function images()
    {
    return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }
}