<?php

namespace App\Providers;

use App\Data\Belajar;
use App\Data\Larav;
use App\Services\HelloService;
use App\Services\HelloServiceIndonesia;
use Illuminate\Contracts\Support\DeferrableProvider;
use Illuminate\Support\ServiceProvider;

class BelajarLaraProvider extends ServiceProvider implements DeferrableProvider
{

    public array $singletons = [
        HelloService::class => HelloServiceIndonesia::class,//kalau sederhana gunakan ini saja
    ];

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        // echo 'tidak dipanggil jika tidak dibutuhkan';//akan terpanggil terus kalau menjalankan unit test
        $this->app->singleton(Belajar::class, function ($app) {
            return new Belajar();
        });

        $this->app->singleton(Larav::class, function ($app) {
            return new Larav($app->make(Belajar::class));
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    
    // tidak akan di load kecuali dipakai
    //hapus cache service agar generate ulang yang terbaru
    // php artisan clear-compiled
    // pada unit test tidak berpengaruh. semua di load
    // LAZY
    public function provides(): array
    {
        return [HelloService::class, Belajar::class, Larav::class];
    }
}