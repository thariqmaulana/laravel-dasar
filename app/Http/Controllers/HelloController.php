<?php

namespace App\Http\Controllers;

use App\Services\HelloService;
use Illuminate\Http\Request;

class HelloController extends Controller
{
    private HelloService $helloService;//sudah teregistrasi di provider. 

    public function __construct(HelloService $helloService)
    {
        $this->helloService = $helloService;
    }

    //Req di param ke-1
    public function hello(Request $request, string $name): string
    {
        return $this->helloService->hello($name);
    }

    public function request(Request $request): string 
    {
        return $request->path() . PHP_EOL . 
            $request->url() . PHP_EOL .
            $request->fullUrl() . PHP_EOL .
            $request->method() . PHP_EOL .
            $request->header('Accept') . PHP_EOL;
    }
}
