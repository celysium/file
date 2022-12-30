<?php

namespace Celysium\File\tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreCreationSuccessful()
    {
        $description = 'My test image';

        $response = $this->postJson(route('file.store'), [
            'file' => UploadedFile::fake()->image('test.jpg'),
            'description' => $description
        ]);

        $response->assertSuccessful()
            ->assertJsonStructure([]);

        $this->assertDatabaseHas('files', [
            'path' => '',
            'description' => $description
        ]);
    }

    public function testDeleteFile()
    {
    }
}
