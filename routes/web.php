<?php

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

// Route::get('/', function () {
//     // return view('welcome');
//     return redirect('login');
// });

Auth::routes(['verify' => true]);
Auth::routes(['register' => false]);

Route::post('login', 'Auth\LoginController@authenticate');
Route::post('verify', 'Auth\LoginController@emailVerify')->name('email-verify');
Route::get('/', 'FinderController@index')->name('finder');//->middleware(['role:admin']);
Route::get('finder/search', 'FinderController@search')->name('finder.search');//->middleware(['role:admin']);
Route::get('finder/vote', 'FinderController@vote')->name('finder.vote');//->middleware(['role:admin']);

// Route::get('/home', function() {
//     return view('home');
// })->name('home')->middleware('auth');
Route::group(['middleware' => ['auth']], function () { //  'verified',
    Route::get('/home', 'HomeController@index')->name('home');//->middleware(['role:admin']);
    Route::get('reload', 'HomeController@reload')->name('reload');//->middleware(['role:admin']);
    Route::get('reload-status', 'HomeController@reloadStatus')->name('reload_status');//->middleware(['role:admin']);
    
    // Role Menu
    Route::get('role', 'RolesController@index')->name('role');
    Route::get('role/assign/{id?}', 'RolesController@assign')->name('role.assign');
    Route::post('role/saveAssign', 'RolesController@saveAssign')->name('role.saveAssign');

    // Permission Menu
    Route::get('permission', 'PermissionsController@index')->name('permission');
    Route::get('permission/create', 'PermissionsController@create')->name('permission.create');
    Route::post('permission/save', 'PermissionsController@save')->name('permission.save');

    // User Menu
    Route::get('user', 'UsersController@index')->name('user');
    Route::get('get-user-data', 'UsersController@getData')->name('user.getdata');
    Route::post('get-user-detail', 'UsersController@show')->name('user.show');
    Route::get('user/create', 'UsersController@create')->name('user.create');
    Route::get('user/edit/{id?}', 'UsersController@edit')->name('user.edit');
    Route::post('user/save/{id?}', 'UsersController@save')->name('user.save');
    Route::get('user/delete/{id?}', 'UsersController@destroy')->name('user.delete');
    Route::get('user/change-password', 'UsersController@changePassword')->name('user.change_password');
    Route::post('user/save-password/{id?}', 'UsersController@savePassword')->name('user.save_password');

    // Book Menu
    Route::get('book', 'BooksController@index')->name('book');
    Route::get('get-book-data', 'BooksController@getData')->name('book.getdata');
    Route::post('get-book-detail', 'BooksController@show')->name('book.show');
    Route::get('book/edit/{id?}', 'BooksController@edit')->name('book.edit');
    Route::post('book/save/{id?}', 'BooksController@save')->name('book.save');
    Route::get('book/delete/{id?}', 'BooksController@destroy')->name('book.delete');

});
