<?php

namespace Database\Factories;

use Celysium\File\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;


class FileFactory extends Factory
{

    protected $model = File::class;

    public function definition()
    {
        return [
            'path' => $this->faker->filePath(),
        ];
    }
}
