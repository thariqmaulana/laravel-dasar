<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ViewTest extends TestCase
{
    public function testView()
    {
        $this->get('hello')
            ->assertSeeText('Halo thariq');

        $this->get('hello-again')
            ->assertSeeText('Halo thariq');
    }

    public function testViewNested()
    {
        $this->get('/hello-nested')
            ->assertSeeText('World thariq');
    }

    public function testViewWithoutRoute()
    {
        //test templatenya/view saja
        $this->view('hello', ['name' => 'thariq'])
            ->assertSeeText('Halo thariq');

        $this->view('hello.world', ['name' => 'thariq'])
            ->assertSeeText('World thariq');
    }
}
