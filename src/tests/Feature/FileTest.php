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
        $fileDataCreation = File::factory()->formData()->create();

        $response = $this->postJson(route('file.store'), $fileDataCreation);

        $response->assertCreated()
            ->assertJson(fn(AssertableJson $json) => $json
                ->hasAll('messages', 'data', 'meta')
                ->has('data.id')
                ->where('data.description', $fileDataCreation['description'])
            );
    }

    public function testDeleteFileWithoutForceDelete()
    {
        $file = File::factory()->create();

        $this->deleteJson(route('files.delete'), [
            'files' => [$file->id]
        ])->assertOk();

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
        ])->assertOk();

        $this->assertDatabaseMissing('files', [
            'id' => $file->id
        ]);

        Storage::assertMissing($file->path);
    }

    public function testGetListOfFile()
    {
        $files = File::factory(10)->create();

        $this->getJson(route('files.index'))
            ->assertOk()
            ->assertJsonCount(10, 'data')
            ->assertJson(fn(AssertableJson $json) => $json
                ->hasAll('messages', 'data', 'meta')
                ->has('data.id')
                ->where('path', $files->first()->path)
                ->where('description', $files->first()->description)
            );
    }
}
