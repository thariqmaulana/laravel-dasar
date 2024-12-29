<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Symfony\Component\VarDumper\VarDumper;
use Tests\TestCase;

class InputControllerTest extends TestCase
{
    public function testInput()
    {
        $this->get('input/hello?name=thariq')
            ->assertSeeText('Hello thariq');

        $this->post('/input/hello', ['name' => 'thariq'])
            ->assertSeeText('Hello thariq');
    }

    public function testInputNested()
    {
        $this->post('/input/first', [
            'name' => [
                'first' => 'thariq'
            ]
        ])->assertSeeText('Hello thariq');
    }

    public function testAllInput()
    {
        $this->post('/input/hello/input', [
            'name' => [
                'first' => 'thariq',
                'last' => 'maulana'
            ]
        ])->assertSeeText('name')->assertSeeText('first')->assertSeeText('thariq')
            ->assertSeeText('last')->assertSeeText('maulana');
    }

    public function testArrayInput()
    {
        $this->post('/input/array', [
            'products' => [
                [
                    'name' => 'laptop',
                    'price' => 1000
                ],
                [
                    'name' => 'hp',
                    'price' => 500
                ],
            ]
        ])->assertSeeText('laptop')->assertSeeText('hp');
    }

    public function testInputType()
    {
        $this->post('/input/type', [
            'name' => 'thariq',
            'married' => 'false',
            'date' => '2001-05-16'
        ])->assertSeeText('false')->assertSeeText('thariq')
            ->assertSeeText('married')->assertSeeText('2001-05-16');
    }

    public function testInputFilterOnly()
    {
        $this->post('input/filter-only', [
            'name' => [
                'first' => 'thariq',
                'last' => 'maulana',
                'gender' => 'male'
            ]
        ])->assertSeeText('first')->assertSeeText('thariq')
            ->assertSeeText('last')->assertSeeText('maulana')
            ->assertDontSeeText('gender')->assertDontSeeText('male');
    }

    public function testInputFilterExcept()
    {
        $this->post('input/filter-except', [
            'first' => 'thariq',
            'last' => 'maulana',
            'gender' => 'male',
            'admin' => 'true'
        ])->assertSeeText('first')->assertSeeText('thariq')
            ->assertSeeText('last')->assertSeeText('maulana')
            ->assertSeeText('gender')->assertSeeText('male')
            ->assertDontSeeText('admin')->assertDontSeeText('true');
    }

    public function testInputFilterMerge()
    {
        $this->post('input/filter-merge', [
            'first' => 'thariq',
            'last' => 'maulana',
            'gender' => 'male',
            'admin' => 'true'
        ])->assertSeeText('first')->assertSeeText('thariq')
            ->assertSeeText('last')->assertSeeText('maulana')
            ->assertSeeText('gender')->assertSeeText('male')
            ->assertSeeText('admin')->assertSeeText('false');
    }
}
