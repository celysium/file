<?php

namespace Celysium\File\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property string $path
 * @property string $description
 */
class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'path' => $this->path,
            'description' => $this->description
        ];
    }
}
