<?php

namespace Celysium\File\tests\Feature;

use App\Models\File;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;

class FileTest extends TestCase
{
    use RefreshDatabase;

    public function testStoreCreationSuccessful()
    {
        $description = fake()->sentence();

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

    public function testDeleteFileWithoutForceDelete()
    {
        $file = File::factory()->create();

        $this->deleteJson(route('files.delete'), [
            'files' => [$file->id]
        ])->assertSuccessful();

        $this->assertDatabaseMissing('files', [
            'id' => $file->id
        ]);
    }

    public function testDeleteFileForceDelete()
    {
        $file = File::factory()->create();

        $createdFileInStorage = UploadedFile::fake()->image($file->path);

        $this->deleteJson(route('files.delete'), [
            'files' => $file->id,
            'is_force_delete' => true
        ])->assertSuccessful();

        $this->assertDatabaseMissing('files', [
            'id' => $file->id
        ]);

        Storage::assertMissing($file->path);
    }

    public function testGetListOfFile()
    {
        $files = File::factory(10)->create();

        $this->getJson(route('files.index'))
            ->assertSuccessful()
            ->assertJsonCount(10, 'data')
            ->assertJson(fn(AssertableJson $json) => $json
                ->hasAll('messages', 'data', 'meta')
            );
    }
}
