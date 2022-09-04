<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\Web\Dashboard\CategoryController;
use App\Http\Controllers\Web\Dashboard\LocalizationController;
use App\Http\Controllers\Web\Dashboard\ProductController;
use App\Http\Controllers\Web\Dashboard\RestaurantController;
use App\Http\Controllers\Web\Dashboard\SubCategoryController;
use App\Http\Controllers\Web\UserManagement\PermissionController;
use App\Http\Controllers\Web\UserManagement\RoleController;
use App\Http\Controllers\Web\UserManagement\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

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

Auth::routes();
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function () {
    Route::post('lang', [LocalizationController::class, 'setLang']);
    Route::get('/admin/impersonateBack', [UserController::class, 'impersonate_back'])->name('impersonate_back');

});

Route::group(['middleware' => ['auth', 'role:admin']], function () {
    Route::resource('/roles', RoleController::class);
    Route::post('/roles/{role}/permissions', [RoleController::class, 'givePermission'])->name('roles.permissions');
    Route::delete('/roles/{role}/permissions/{permission}', [RoleController::class, 'revokePermission'])->name('roles.permissions.revoke');
    Route::resource('/permissions', PermissionController::class);
    Route::post('/permissions/{permission}/roles', [PermissionController::class, 'assignRole'])->name('permissions.roles');
    Route::delete('/permissions/{permission}/roles/{role}', [PermissionController::class, 'removeRole'])->name('permissions.roles.remove');
    Route::resource('/users', UserController::class);
    Route::get('/users/showRoles/{user}', [UserController::class, 'showRoles'])->name('users.showRoles');
    Route::post('/users/{user}/roles', [UserController::class, 'assignRole'])->name('users.roles');
    Route::delete('/users/{user}/roles/{role}', [UserController::class, 'removeRole'])->name('users.roles.remove');
    Route::post('/users/{user}/permissions', [UserController::class, 'givePermission'])->name('users.permissions');
    Route::delete('/users/{user}/permissions/{permission}', [UserController::class, 'revokePermission'])->name('users.permissions.revoke');


    Route::get('/admin/{user}/impersonate', [UserController::class, 'impersonate'])->name('impersonate');
});

Route::group(['middleware' => ['auth', 'role:admin|owner']], function () {
    Route::resource('/restaurants', RestaurantController::class);
    Route::get('/restaurants/{restaurant}/products', [RestaurantController::class , 'showProducts'])->name('restaurants.showProduct');
    Route::get('/restaurants/{restaurant}/users', [RestaurantController::class , 'showOwner'])->name('restaurants.showOwner');
    Route::resource('/products', ProductController::class);
    Route::resource('/categories', CategoryController::class);
    Route::get('/categories/{category}/products', [CategoryController::class , 'showProducts'])->name('categories.showProducts');
    Route::get('/categories/{category}/restaurants', [CategoryController::class , 'showRestaurants'])->name('categories.showRestaurants');

    Route::resource('/subcategories', SubCategoryController::class);
});
