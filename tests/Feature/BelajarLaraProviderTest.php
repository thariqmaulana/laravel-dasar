<?php

namespace Tests\Feature;

use App\Data\Belajar;
use App\Data\Larav;
use App\Services\HelloService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;
use function PHPUnit\Framework\assertSame;

class BelajarLaraProviderTest extends TestCase
{
    /**Ketika unit test mungkin terlihat gampang membuat registrasi disini langsung
     * tapi kalau di real app tentu akan berantakan
     * makanya di service provider
     */
    public function testServiceProvider()
    {
        $belajar1 = $this->app->make(Belajar::class);
        $belajar2 = $this->app->make(Belajar::class);

        self::assertEquals($belajar1, $belajar2);
        // sama karena kita registrasikan di service provider
        // di load ketika awal booting
        // kalau tidak pasti beda

        $larav = $this->app->make(Larav::class);

        self::assertEquals($larav->belajar, $belajar1);
    }

    public function testSingletonArray()
    {
        $helloService1 = $this->app->make(HelloService::class);
        $helloService2 = $this->app->make(HelloService::class);
        
        assertEquals('Halo Thariq', $helloService1->hello('Thariq'));
        assertSame($helloService1, $helloService2);
    }
}
