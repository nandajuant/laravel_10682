<?php

use App\Models\Instruktur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('/pegawais',
App\Http\Controllers\PegawaiController::class);

Route::apiResource('/members',
App\Http\Controllers\MemberController::class);

Route::apiResource('/promos',
App\Http\Controllers\PromoController::class);

Route::put('/members/reset/{id}',
'App\Http\Controllers\MemberController@reset');

Route::apiResource('/instrukturs',
App\Http\Controllers\InstrukturController::class);

Route::apiResource('/izinInstrukturs',
App\Http\Controllers\IzinInstrukturController::class);

Route::get('/jadwal_harians/generate,
App\Http\Controllers\JadwalHarianController::class');

Route::apiResource('/jadwal_harians',
App\Http\Controllers\JadwalHarianController::class);

Route::apiResource('/jadwal_umums',
App\Http\Controllers\JadwalUmumController::class);

Route::apiResource('/aktivasis',
App\Http\Controllers\AktivasiController::class);

Route::apiResource('/deposit_pakets',
App\Http\Controllers\DepositPaketController::class);

Route::apiResource('/deposit_regulers',
App\Http\Controllers\DepositRegulerController::class);

Route::apiResource('/kelas',
App\Http\Controllers\KelasController::class);

Route::apiResource('/izin_instrukturs',
App\Http\Controllers\IzinInstrukturController::class);

Route::apiResource('/booking_pakets',
App\Http\Controllers\BookingPaketController::class);
Route::apiResource('/booking_regulers',
App\Http\Controllers\BookingRegulerController::class);
Route::apiResource('/booking_gyms',
App\Http\Controllers\BookingGymController::class);

Route::post('/loginAndroid', 'InstrukturController@loginAndroid');

// Route::post('/members/deaktivasi', 'App\Http\Controllers\MemberController@deaktivasi');
Route::post('/members/deaktivasi', 'App\Http\Controllers\MemberController@deaktivasi');
Route::post('/members/resetDeposit', 'App\Http\Controllers\MemberController@resetDeposit');
Route::get('/showDeaktivasi', 'App\Http\Controllers\MemberController@showDeaktivasi');
Route::get('/showResetDeposit', 'App\Http\Controllers\MemberController@showResetDeposit');

Route::post('register', 'App\Http\Controllers\AuthController@register');
Route::post('login', 'App\Http\Controllers\AuthController@login');

Route::get('/data', function() {
    $data = Instruktur::table('instruktur')->get();
    return response()->json($data);
});
// Route::get('/logout', 
// 'App\Http\Controllers\AuthController@logout');

// Route::post('pegawais/login', 'Api\PegawaiController@login');
// Route::get('pegawais/logout', 'Api\PegawaiController@logout');

// Route::middleware('auth:api')->get('/pegawais', function (Request $request) {
//     return $request->pegawai();
//  });
// Route::middleware('auth:sanctum')->get('/pegawais', function (Request $request) {
//     return $request->pegawai();
//  });

