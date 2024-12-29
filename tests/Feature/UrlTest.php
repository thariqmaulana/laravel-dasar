<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UrlTest extends TestCase
{
    public function testUrl()
    {
        $this->get('/url/current?name=thariq')
            ->assertSeeText('http://localhost/url/current?name=thariq');
    }

    public function testNamed()
    {
        $this->get('/redirect/named')
            ->assertSeeText('/redirect/name/thariq');
    }

    public function testActionUrl()
    {
        $this->get('/url/action')
            ->assertSeeText('/form');
    }
}
