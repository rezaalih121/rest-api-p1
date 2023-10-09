<?php
use App\Models\Product;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
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
| To check Routes : php artisan route:list
| 
| To instal sanctum 
| 1 : composer require laravel/sanctum
| 2 : php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
| 3 : php artisan migrate
| 4 : replace api in app/Kernel.php
*/


// public routes

// this will automatically create all the default route for the controller
//Route::resource('products', ProductController::class);
Route::post('/register' , [AuthController::class , 'register']);
Route::post('/login' , [AuthController::class , 'login']);

Route::get('/products/{id}' , [ProductController::class,'show']);

// To search with product name
Route::get('/products/search/{name}' , [ProductController::class,'search']);



// Protected routes

Route::group(['middleware' => ['auth:sanctum']], function() {
Route::get('/products' , [ProductController::class,'index']);
Route::post('/products' , [ProductController::class , 'store']);
Route::put('/products/{id}' , [ProductController::class , 'update']);
Route::delete('/products/{id}' , [ProductController::class , 'destroy']);
Route::post('/logout' , [AuthController::class , 'logout']);

});


Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
