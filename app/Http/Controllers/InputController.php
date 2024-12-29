<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InputController extends Controller
{
    public function hello(Request $request): string
    {
        $name = $request->input('name');
        return "Hello $name";
    }

    public function helloFirst(Request $request): string
    {
        $firstName = $request->input('name.first');
        return "Hello $firstName";
    }

    public function helloInput(Request $request)
    {
        $allInput = $request->input();
        return json_encode($allInput);
    }

    public function array(Request $request)
    {
        $names = $request->input('products.*.name');
        return json_encode($names);
    }

    public function inputType(Request $request): string
    {
        // auto konversi 
        $name = $request->input('name');
        // $married = $request->input('married');masih string
        $married = $request->boolean('married');
        $date = $request->date('date', 'Y-m-d');

        return json_encode([
            'name' => $name,
            'married' => $married,
            'date' => $date->format('Y-m-d'),//ada methodnya. library carbon
        ]);
    }

    public function filterOnly(Request $request): string
    {
        $name = $request->only('name.first', 'name.last');
        return json_encode($name);
    }

    public function filterExcept(Request $request): string 
    {
        $user = $request->except('admin');
        //misal kita mau ambil semua data, tapi jangan sampai kebobolan admin true.
        //admin tidak dirubah melalui form tentu saja
        return json_encode($user);
    }

    public function filterMerge(Request $request): string
    {
        $request->merge(['admin' => false]);
        $user = $request->input();
        return json_encode($user);
    }
}
