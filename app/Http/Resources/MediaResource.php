<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $responsiveImage = $this->responsiveImages()->files->first();

        return [
            'name' => $this->name,
            'url' => $this->getUrl(),
            'srcset' => $this->getSrcset(),
            'width' => $responsiveImage?->width(),
            'height' => $responsiveImage?->height(),
            'loading' => config('media-library.default_loading_attribute_value'),
        ];
    }
}
