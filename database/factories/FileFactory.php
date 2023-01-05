<?php

namespace Database\Factories;

use Celysium\File\Models\File;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Http\UploadedFile;


class FileFactory extends Factory
{

    protected $model = File::class;

    public function definition(): array
    {
        return [
            'path' => $this->faker->filePath(),
            'description' => $this->faker->sentence(),
            'extension' => $this->faker->fileExtension(),
        ];
    }

    public function formData(): FileFactory
    {
        return $this->state(function (array $attributes) {
            return [
              'file' => UploadedFile::fake()->image(
                  $this->faker->file() . '.' . $this->faker->fileExtension()
              )
            ];
        });
    }
}
