<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class CookieController extends Controller
{
    public function createCookie(Request $request): Response
    {
        return response('Hello Cookie')
            ->cookie('User-Id', 'thariq', 1000, '/')
            ->cookie('Is-Member', 'true', 1000, '/');

        /**Cookie
         * cookie akan di kirim melalui response
         * Dan browser akan mengirim cookie sesuai path yang kita tentukan di atas, dan kebelakangnya
         */
    }

    public function getCookie(Request $request): JsonResponse
    {
        return response()
            ->json([
                'userId' => $request->cookie('User-Id', 'guest'),
                'isMember' => $request->cookie('Is-Member', 'false')
            ]);
    }

    public function clearCookie(Request $request): Response
    {
        // di browser otomatis di hapus
        // membuat cookie dengan value kosong dan sudah expire 5 tahun lalu
        return response('Clear Cookie')
            ->withoutCookie('User-Id')
            ->withoutCookie('Is-Member');
    }
}
