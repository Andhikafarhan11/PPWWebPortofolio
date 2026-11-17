<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'judul',
        'slug',
        'category_id',
        'thumbnail',
        'kategori',
        'short_description',
        'deskripsi',
        'tautan',
        'project_url',
        'repository_url',
        'project_date',
        'is_featured',
        'status',
    ];

    protected $casts = [
        'project_date' => 'date',
        'is_featured'  => 'boolean',
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'deleted_at'   => 'datetime',
    ];

    protected static function booted()
    {
        static::saving(function ($project) {
            if (empty($project->slug) && !empty($project->judul)) {
                $project->slug = Str::slug($project->judul);
            }
        });
    }

    public function scopePublished(Builder $query): Builder
    {
        return $query->where('status', 'published');
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if ($term) {
            return $query->where(function ($q) use ($term) {
                $q->where('judul', 'like', '%' . $term . '%')
                  ->orWhere('short_description', 'like', '%' . $term . '%')
                  ->orWhere('deskripsi', 'like', '%' . $term . '%');
            });
        }

        return $query;
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function technologies()
    {
        return $this->belongsToMany(Technology::class, 'project_technology');
    }

    public function images()
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order');
    }
}