<?php

namespace Celysium\File\Database\Factories;

use Celysium\File\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;


class FileFactory extends Factory
{

    protected $model = File::class;

    public function definition(): array
    {
        return [
            'path' => $this->faker->filePath(),
            'description' => $this->faker->sentence(),
            'mime_type' => $this->faker->mimeType(),
        ];
    }
}
