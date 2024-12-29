<?php

namespace Tests\Feature;

use App\Data\Belajar;
use App\Data\Larav;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use function PHPUnit\Framework\assertEquals;

class DependencyInjectionTest extends TestCase
{
    public function testDependencyInjection()
    {
        // rekomendasinya di constructor seperti ini
        $belajar = new Belajar();
        $larav = new Larav($belajar);

        assertEquals('Belajar Larav', $larav->larav());
    }
}
