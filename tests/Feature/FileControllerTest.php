<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

class FileControllerTest extends TestCase
{
    public function testupload()
    {
        $picture = UploadedFile::fake()->image('fake.png');
        $this->post('file/upload', [
            'picture' => $picture
        ])->assertSeeText('OK fake.png');
    }
}
