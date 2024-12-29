<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Env;
use Tests\TestCase;


class EnvironmentTest extends TestCase
{
    public function testGetEnvironment()
    {
        $youtube = env('YOUTUBE');

        var_dump(Env::get('YOUTUBE'));//Facade

        self::assertEquals('Thariq Maulana', $youtube);

        $author = env('AUTHOR', 'thariq');//Default Value

        self::assertEquals('thariq', $author);
    }
}
