<?php

namespace Tests\Feature;

use App\Data\Belajar;
use App\Data\Larav;
use App\Data\Person;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ServiceContainerTest extends TestCase
{
    public function testDependency()
    {
        //Make

        $belajar1 = $this->app->make(Belajar::class); //new belajar()
        $belajar2 = $this->app->make(Belajar::class); //new belajar()

        self::assertEquals('Belajar', $belajar1->belajar());
        self::assertEquals('Belajar', $belajar2->belajar());
        self::assertNotSame($belajar1, $belajar2);
    }

    public function testBind()
    {
        //Bind

        // $person = $this->app->make(Person::class);ada constructor dengan 2 param. tidak bisa begini langsung
        // new person(...,...)
        $this->app->bind(Person::class, function ($app) {
            return new Person('thariq', 'maulana');
        });

        $person1 = $this->app->make(Person::class);//new Person()
        $person2 = $this->app->make(Person::class);//new Person()

        self::assertEquals('thariq', $person1->firstName);
        self::assertEquals('thariq', $person2->firstName);
        self::assertNotSame($person1, $person2);
    }

    public function testSingleton()
    {
        $this->app->singleton(Person::class, function ($app) {
            return new Person('thariq', 'maulana');
        });
        
        $person1 = $this->app->make(Person::class);//new person if not exist
        $person2 = $this->app->make(Person::class);//return existing obj

        self::assertEquals('thariq', $person1->firstName);
        self::assertEquals('thariq', $person2->firstName);
        self::assertSame($person1, $person2);
    }

    public function testInstance()
    {
        $person = new Person('thariq', 'maulana');
        $this->app->instance(Person::class, $person);

        $person1 = $this->app->make(Person::class);//person
        $person2 = $this->app->make(Person::class);//person

        self::assertEquals('thariq', $person1->firstName);
        self::assertEquals('thariq', $person2->firstName);
        self::assertSame($person1, $person2);
    }

    public function testDependencyInjection()
    {
        //otomatis inject
        $belajar = $this->app->make(Belajar::class);
        $larav = $this->app->make(Larav::class);

        self::assertNotNull($larav->belajar);
        self::assertNotSame($belajar, $larav->belajar);
    }

    public function testDependencyInjectionSingleton()
    {
        //otomatis inject dengan singleton
        $this->app->singleton(Belajar::class, function ($app) {
            return new Belajar();
        });

        $belajar = $this->app->make(Belajar::class);
        $larav = $this->app->make(Larav::class);

        self::assertSame($belajar, $larav->belajar);//sama
    }

    public function testDependencyInjectionSingletonInClosure()
    {
        $this->app->singleton(Belajar::class, function ($app) {
            return new Belajar();
        });
        
        $larav1 = $this->app->make(Larav::class);
        $larav2 = $this->app->make(Larav::class);

        self::assertNotSame($larav1, $larav2);//masih beda karena belum singleton

        /**Obj larav belum singleton
         * kita perlu meregristasikannya terlebih dahulu sebagai singleton
         * masalahnya adalah ketika new larav, kita perlu memasukkan belajar
         * nah bagaimana caranya? agar menggunakan belajar singleton
         * kita gunakan param app untuk mengambil obj
         */

         $this->app->singleton(Larav::class, function ($app) {
            // return new Larav(new Belajar());jangan
            
            // $belajar = $app->make(Belajar::class);
            // return new Larav($belajar);
            return new Larav($app->make(Belajar::class));
         });

         $larav3 = $this->app->make(Larav::class);
         $larav4 = $this->app->make(Larav::class);

         self::assertSame($larav3, $larav4);//sudah sama
    }

    public function testInterfaceToClass()
    {
        $this->app->singleton(HelloService::class, HelloServiceIndonesia::class);

        $helloService = $this->app->make(HelloService::class);

        self::assertEquals('Halo Thariq', $helloService->hello('Thariq'));
    }
}
