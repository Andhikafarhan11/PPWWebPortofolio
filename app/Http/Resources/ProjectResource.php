<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'title'        => $this->judul,
            'slug'         => $this->slug,
            'summary'      => $this->short_description ?? $this->deskripsi,
            'thumbnail'    => $this->thumbnail ? asset('storage/' . $this->thumbnail) : null,
            'category'     => $this->category?->name ?? $this->kategori,
            'technologies' => $this->technologies->pluck('name'),
        ];
    }
}