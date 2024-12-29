<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class SessionControllerTest extends TestCase
{
    public function testCreateSession()
    {
        $this->get('/session/create')
            ->assertSeeText('OK')
            ->assertSessionHas('userId', 'thariq')
            ->assertSessionHas('isMember', 'true');
    }

    public function testGetSession()
    {
        // $this->get('/session/create');//buat dulu sesi

        $this->withSession([
            'userId' => 'thariq',
            'isMember' => 'true'
        ])->get('/session/get')
            ->assertSeeText('User ID : thariq, Is Member : true')
            ->assertSessionHas('userId', 'thariq')
            ->assertSessionHas('isMember', 'true');
    }

    public function testGetSessionInvalid()
    {
        $this->get('/session/get')
            ->assertSeeText('User ID : guest, Is Member : false');
            // ->assertSessionHas('userId', 'guest')//bagaimana mau melacak userId. kan tidak mengirim apa apa
            // ->assertSessionHas('isMember', 'false');
    }
}
