<?php
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\DataCenterController;
use App\Http\Controllers\Api\Auth\LoginController;

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
Route::prefix('v1')->group(function() {
  Route::post('/login', [LoginController::class, 'login']);
  Route::post('/logout', [LoginController::class, 'logout'])->middleware('auth:api');
  Route::get('/test', [DataCenterController::class, 'test_api']);
  Route::get('/helo-event', [DataCenterController::class, 'HeloEvent']);
});


Route::middleware('auth:api')->get('/user', function (Request $request) {
  return $request->user();
});