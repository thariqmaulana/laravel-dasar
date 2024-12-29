<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class RoutingTest extends TestCase
{
    public function testGet()
    {
        $this->get('/thariq')
            ->assertStatus(200)
            ->assertSeeText('Halo Thariq');
    }

    public function testRedirect()
    {
        $this->get('/youtube')
            ->assertRedirect('/thariq');
    }


    public function testFallback()
    {
        $this->get('/salah')
            ->assertSeeText('404 By Thariq');
    }

    public function testRouteParameter()
    {
        $this->get('/products/1')
            ->assertSeeText('Product : 1');

        $this->get('/products/1/items/abc')
            ->assertSeeText('Product : 1, Item : abc');
    }

    public function testRouteParameterRegex()
    {
        $this->get('/categories/123')
            ->assertSeeText('Category : 123');

            $this->get('categories/salah')
            ->assertSeeText('404 By Thariq');
    }

    public function testRouteParameterRegexOpt()
    {
        $this->get('/users/123')
            ->assertSeeText('User : 123');

            $this->get('/users/')
            ->assertSeeText('User : 404');
    }

    public function testNamedRoute()
    {
        $this->get('/produk/123')
            ->assertSeeText('Link : http://localhost/products/123');

        $this->get('/produk-redirect/123')
            ->assertRedirect('/products/123');
    }
}
