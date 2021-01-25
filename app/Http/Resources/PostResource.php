<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return array_merge(parent::toArray($request), [
            'author' => $this->author,
            'thumbnail' => new MediaResource($this->thumbnail),
            'excerpt' => Str::words($this->content, 20),
            'status' => $this->when($request->is('admin/*'), $this->status),
        ]);
    }
}
