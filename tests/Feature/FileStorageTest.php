<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FileStorageTest extends TestCase
{
    public function testStorage()
    {
        $filesystem = Storage::disk('local');

        $filesystem->put('file.txt', 'Thariq Maulana');//lihat di disk kemana

        self::assertEquals('Thariq Maulana', $filesystem->get('file.txt'));
    }

    public function testPublic()
    {
        /**Bagaimana user bisa mengakses file? sedangkan ini bukan di folder public
         * caranya adalah dengan mengggunakan link. yang nanti akan menghubungkan ke folder storage/public
         * Cara mengakses
         * index.php/storage/nama-file
         */
        $filesystem = Storage::disk('public');

        $filesystem->put('file.txt', 'Thariq Maulana');//lihat di disk kemana

        self::assertEquals('Thariq Maulana', $filesystem->get('file.txt'));
    }
}
