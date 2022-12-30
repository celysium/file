<?php

namespace Celysium\File\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
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
            'id' => $this->id,
            'path' => $this->path,// TODO : pass url too , get url concat image path => storage::url() laravel method
            // TODO : remove path
            // TODO : app_URL ro bekhune
            'description' => $this->description
        ];
    }
}
