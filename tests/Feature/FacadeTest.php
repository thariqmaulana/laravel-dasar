<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class FacadeTest extends TestCase
{
    /**Facades
     * Facades digunakan ketika kita tidak bisa menggunakan $app(service container)
     * Gunakan dependency injection jika masih memungkinkan
     */

    /**Facades vs Helper
     * Facades: Facade::env
    Helper: env() : didalamnya juga sebenarnya memanggil facade.
    Lebih baik menggunakan Facade untuk keterbacaan kode
    Lebih mudah juga di test
     */
    public function testFacade()
    {
        $firstName1 = config('contoh.author.first');
        $firstName2 = Config::get('contoh.author.first');

        self::assertEquals($firstName1, $firstName2);

        $config = $this->app->make('config');
        /**seperti ini sebenarnya
         * jadi dia mengirim key untuk obj yang akan dibuat yang ada di dalam service container
         */

        $firstName3 = $config->get('contoh.author.first');

        self::assertEquals($firstName1, $firstName3);
    }

    public function testFacadeMock()
    {
        Config::shouldReceive('get')
            ->with('contoh.author.first')
            ->andReturn('tidak mengambil sebenarnya');

        $firstName = Config::get('contoh.author.first');

        self::assertEquals('tidak mengambil sebenarnya', $firstName);
    }
}
