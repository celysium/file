<?php

namespace Celysium\File\Resources;

use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use JsonSerializable;

/**
 * @property int $id
 * @property string $path
 * @property string $type
 * @property string $description
 */
class FileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  Request  $request
     * @return array|Arrayable|JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => Storage::url($this->path),
            'description' => $this->description,
            'type' => $this->type,
        ];
    }
}
