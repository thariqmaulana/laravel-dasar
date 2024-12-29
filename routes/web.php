<?php

use App\Exceptions\ValidationException;
use App\Http\Controllers\CookieController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\FormController;
use App\Http\Controllers\HelloController;
use App\Http\Controllers\InputController;
use App\Http\Controllers\RedirectController;
use App\Http\Controllers\ResponseController;
use App\Http\Controllers\SessionController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;

use function Termwind\render;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/thariq', function () {
    return 'Halo Thariq';
});

Route::redirect('youtube', 'thariq');

Route::fallback(function () {
    return '404 By Thariq';
});

Route::view('/hello', 'hello', ['name' => 'thariq']);

Route::get('/hello-again', function () {
    return view('hello', ['name' => 'thariq']);
});

Route::get('/hello-nested', function () {
    return view('hello.world', ['name' => 'thariq']);
});

Route::get('/products/{id}', function ($productId) { //sesuai urutan 
    return "Product : $productId";
})->name('product.detail');

Route::get('products/{product}/items/{item}', function ($productId, $itemId) {
    return "Product : $productId, Item : $itemId";
})->name('product.item.detail');

Route::get('/categories/{id}', function ($categoryId) {
    return "Category : $categoryId";
})->where('id', '[0-9]+')->name('category.detail');

Route::get('/users/{id?}', function (string $id = '404') {
    return "User : $id";
})->name('user.detail');

/**Hati hati conflict route */

Route::get('/produk/{id}', function ($id) {
    $link = route('product.detail', [
        'id' => $id
    ]);
    return "Link : $link";
});

Route::get('/produk-redirect/{id}', function ($id) {
    return redirect()->route('product.detail', [
        'id' => $id
    ]);
});


Route::get('/controller/hello/request', [HelloController::class, 'request']); //biar tidak conflict di bawah
Route::get('/controller/hello/{name}', [HelloController::class, 'hello']); //otomatis masuk sbg param di fn

Route::get('/input/hello', [InputController::class, 'hello']);
Route::post('/input/hello', [InputController::class, 'hello']);
Route::post('/input/hello/first', [InputController::class, 'helloFirst']);
Route::post('/input/hello/input', [InputController::class, 'helloInput']);
Route::post('/input/array', [InputController::class, 'array']);
Route::post('/input/type', [InputController::class, 'inputType']);
Route::post('/input/filter-only', [InputController::class, 'filterOnly']);
Route::post('/input/filter-except', [InputController::class, 'filterExcept']);
Route::post('/input/filter-merge', [InputController::class, 'filterMerge']);

Route::post('/file/upload', [FileController::class, 'upload']);

Route::get('/response/hello', [ResponseController::class, 'response']);
Route::get('/response/header', [ResponseController::class, 'withHeader']);

Route::controller(ResponseController::class)->group(function () {
    Route::get('/response/view', 'responseView');
    Route::get('/response/json', 'responseJson');
    Route::get('/response/file', 'responseFile');
    Route::get('/response/download', 'responseDownload');
});

Route::prefix('/cookie')->group(function () {
    Route::get('/set', [CookieController::class, 'createCookie']);
    Route::get('/get', [CookieController::class, 'getCookie']);
    Route::get('/clear', [CookieController::class, 'clearCookie']);
});

Route::get('/redirect/from', [RedirectController::class, 'redirectFrom']);
Route::get('/redirect/to', [RedirectController::class, 'redirectTo']);
Route::get('/redirect/name', [RedirectController::class, 'redirectName']);
Route::get('/redirect/name/{name}', [RedirectController::class, 'redirectHello'])
    ->name('redirect-hello');
Route::get('/redirect/named', function () {
    // return route('redirect-hello', ['name' => 'thariq']);
    // url()->route('redirect-hello', ['name' => 'thariq']);
    return URL::route('redirect-hello', ['name' => 'thariq']);
    // ini bukan nge redirect. tapi menampilkan url si redirect-hello
});
Route::get('/redirect/action', [RedirectController::class, 'redirectAction']);
Route::get('/redirect/yt', [RedirectController::class, 'redirectAway']);

Route::middleware(['contoh:TM,401'])->prefix('/middleware')->group(function () {
    Route::get('/api', function () {
        return 'OK';
    });
    Route::get('/group', function () {
        return 'GROUP';
    });
});

Route::get('/form', [FormController::class, 'form']);
Route::post('/form', [FormController::class, 'submitForm']);

Route::get('/url/current', function () {
    return URL::full();
});
Route::get('/url/action', function () {
    return action(FormController::class, 'form');
    // sepertinya lebih readable pakai url atau URL->action
});

Route::get('/session/create', [SessionController::class, 'createSession']);
Route::get('/session/get', [SessionController::class, 'getSession']);

Route::get('/error/sample', function () {
    throw new Exception('Sample Error');
});

Route::get('/error/manual', function () {
    report(new Exception('Manual Report'));
    /**Nah ini mereport error tanpa harus menampilkan error. alias real throw
     * misal gagal konek ke db. kita tidak mau menampilkan halaman error.
     * tapi kita ingin report ke telegram
     * akan dikirim ke reportable
     */
    return 'OK';
});

Route::get('/error/validation', function () {
    throw new ValidationException('validation exception');
});

Route::get('/abort/400', function () {
    abort(400, 'Message from web.php');
});

Route::get('/abort/401', function () {
    abort(401);
});

Route::get('/abort/500', function () {
    abort(500);
});