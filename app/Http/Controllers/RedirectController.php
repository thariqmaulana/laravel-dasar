<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RedirectController extends Controller
{
    public function redirectFrom(): RedirectResponse
    {
        return redirect('/redirect/to');
    }

    public function redirectTo(): string
    {
        return 'Redirect To';
    }

    public function redirectName(): RedirectResponse
    {
        return redirect()->route('redirect-hello', ['name' => 'thariq']);
    }

    public function redirectHello(string $name): string
    {
        return "Hello $name";
    }

    public function redirectAction(): RedirectResponse
    {
        return redirect()->action([RedirectController::class, 'redirectHello'], ['name' => 'thariq']);
    }

    public function redirectAway(): RedirectResponse
    {
        return redirect()->away('https://www.youtube.com');
    }
}
