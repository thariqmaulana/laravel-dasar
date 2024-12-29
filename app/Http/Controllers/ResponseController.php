<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ResponseController extends Controller
{
    public function response(Request $request): Response
    {
        // jika sebelumnya langsung string
        // sekarang kita bungkus dalam obj res
        return response('Hello Response');
    }

    public function withHeader(Request $request): Response
    {
        $body = ['firstName' => 'Thariq', 'lastName' => 'Maulana'];
        return response(json_encode($body), 200)
            ->header('Content-Type', 'application/json')
            ->withHeaders([
                'Author' => 'Thariq Maulana',
                'App' => 'Belajar Laravel'
            ]);
    }

    public function responseView(Request $request): Response
    {
        return response()
            ->view('hello', ['name' => 'thariq']);
    }

    public function responseJson(Request $request): JsonResponse
    {   
        $body = ['firstName' => 'Thariq', 'lastName' => 'Maulana'];
        return response()
            ->json($body);//otomatis content type
    }

    public function responseFile(Request $request): BinaryFileResponse
    {
        return response()
            ->file(storage_path('app/public/pictures/fake.png'));//render
    }

    public function responseDownload(Request $request): BinaryFileResponse
    {
        return response()
            ->download(storage_path('app/public/pictures/fake.png'));//download
    }
}
