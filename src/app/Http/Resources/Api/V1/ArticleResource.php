<?php

namespace App\Http\Resources\Api\V1;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'description' => $this->description,
            'url' => $this->url,
            'url_image' => $this->url_image,
            'published_at' => $this->published_at,
            'author' => new AuthorResource($this->whenLoaded(relationship: 'author')),
            'category' => new CategoryResource($this->whenLoaded('category')),
            'source' => new SourceResource($this->whenLoaded('source')),
        ];
    }
}
