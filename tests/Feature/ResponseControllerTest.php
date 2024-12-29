<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResponseControllerTest extends TestCase
{
    public function testResponse()
    {
        $this->get('/response/hello')->assertSeeText('Hello Response');
    }

    public function testResponseWithHeader()
    {
        $this->get('/response/header')
            ->assertStatus(200)
            ->assertSeeText('Thariq')->assertSeeText('Maulana')
            ->assertHeader('Content-Type', 'application/json')
            ->assertHeader('Author', 'Thariq Maulana')
            ->assertHeader('App', 'Belajar Laravel');
    }

    public function testResponseView()
    {
        $this->get('/response/view')
            ->assertSeeText('Halo thariq');
    }

    public function testResponseJson()
    {
        $this->get('/response/json')
            ->assertJson(['firstName' => 'Thariq', 'lastName' => 'Maulana']);
    }

    public function testResponseFile()
    {
        $this->get('/response/file')
            ->assertHeader('Content-Type', 'image/png');
    }

    public function testResponseDownload()
    {
        $this->get('/response/download')
            ->assertDownload('fake.png');
    }
}
