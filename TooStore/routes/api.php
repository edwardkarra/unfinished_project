<?php
use App\Http\Middleware\UserTokenWall;
use App\Http\Middleware\UserStorageWall;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StorageController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ItemController;
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



Route::Post('/register',[UserController::class, 'register']);
Route::post('/login',[UserController::class,'login']);

Route::middleware([UserTokenWall::class])->group(function () {
    Route::middleware([UserStorageWall::class])->group(function () {
        Route::get('Storage/{storage}/item',[ItemController::class,'Index'] );
        Route::post('Storage/{storage}/item',[ItemController::class,'Store'] );
        Route::post('Storage/{storage}/item/update',[ItemController::class,'Update'] );
        Route::post('Storage/{storage}/item/delete',[ItemController::class,'Delete'] );
    });
    Route::post('/logout',[UserController::class,'logout']);
});
