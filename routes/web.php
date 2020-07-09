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
Route::get('/', 'SiteController@home');
Route::get('/register', 'SiteController@register');
Route::post('/postregister', 'SiteController@postregister');
Route::get('/about', 'SiteController@about');



// Route::get('/dashboard', function () {
//     return view('index');
// });

// Route::get('/About', function () {
// 	$nama = 'anu';
//     return view('about', ['nama' => $nama]);
// });

Route::get('/login', 'AuthController@login')->name('login');
Route::post('/postlogin', 'AuthController@postlogin');
Route::get('/logout', 'AuthController@logout');



Route::group(['middleware'=>['auth','checkRole:admin']],function(){
	Route::get('/dashboard', 'DashboardController@index');
	
	Route::get('/siswa', 'SiswaController@index');
	Route::post('/siswa/create', 'SiswaController@create');
	Route::get('/siswa/{siswa}/edit', 'SiswaController@edit');
	Route::post('/siswa/{siswa}/update', 'SiswaController@update');
	Route::get('/siswa/{siswa}/delete', 'SiswaController@delete');
	Route::get('/siswa/{siswa}/profile', 'SiswaController@profile');
	Route::post('/siswa/{id}/addnilai', 'SiswaController@addnilai');
	Route::get('/siswa/{siswa}/{idmapel}/deletenilai','SiswaController@deletenilai');
	Route::get('/siswa/exportexcel','SiswaController@exportExcel');
	Route::get('/siswa/exportpdf','SiswaController@exportPdf');
	Route::get('/guru/{id}/profile','GuruController@profile');
	Route::get('/posts','PostController@index');
	Route::get('post/add',[
	'uses' => 'PostController@add',
	'as'   => 'posts.add'
	]);
});

Route::group(['middleware'=>['auth','checkRole:admin,siswa']],function(){

	Route::get('/dashboard', 'DashboardController@index');
});

Route::get('/{slug}',[
	'uses' => 'SiteController@singlepost',
	'as'   => 'site.single.post'
]); // posisikan setelah route yg berisi '/' seperti biasa

