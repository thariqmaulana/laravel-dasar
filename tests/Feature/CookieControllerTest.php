<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CookieControllerTest extends TestCase
{
    public function testSetCookie()
    {
        $this->get('/cookie/set')
            ->assertCookie('User-Id', 'thariq')
            ->assertCookie('Is-Member', 'true');
    }

    public function testGetCookie()
    {

        $this->get('/cookie/get')
            ->assertJson([
                'userId' => 'guest',
                'isMember' => 'false'
        ]);

        //set dulu cookienya sebelum tembak
        $this->withCookie('User-Id', 'thariq')
            ->withCookie('Is-Member', 'true')
            ->get('/cookie/get')
            ->assertJson([
                'userId' => 'thariq',
                'isMember' => 'true'
        ]);

        //get selanjutnya tidak perlu kirim cookie lagi apabila berada di 1 unit test yg sama
    }

    public function testClearCookie()
    {
        
        $this->get('/cookie/set')
            ->assertCookie('User-Id', 'thariq')
            ->assertCookie('Is-Member', 'true');

        $this->get('/cookie/clear')
            ->assertCookieExpired('User-Id')
            ->assertCookieExpired('Is-Member');
    }
}
