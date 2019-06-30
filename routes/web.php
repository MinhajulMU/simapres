<?php

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



Route::get('/tes','analisaTopsis@get_ideal'); 
Route::get('/tes2',function(){
    $users = DB::table('mahasiswa')->select(DB::raw('SUM(prestasi) as jumlah'))->first();
    return $users->jumlah;
});
Route::group(['as' =>'admin.','middleware'=> 'auth'],function(){
    Route::get('/', function () {
        return view('admin.dashboard');
    });
    Route::get('/amahasiswa', function () {
        return view('admin.mahasiswa.index');
    });
    Route::get('/asetting', function () {
        $options = \App\Model\Setting::getAllKeyValue();
        return view('admin.setting',$options);
    });
    Route::get('/alinguistik', function () {
        return view('admin.topsis.linguistik');
    });
    Route::get('/amatrix_keputusan', function () {
        return view('admin.topsis.matrix_keputusan');
    });
    Route::get('/amatrix_keputusan_ternormalisasi', function () {
        return view('admin.topsis.matrix_keputusan_ternormalisasi');
    });
    Route::get('/amatrix_keputusan_terbobot', function () {
        return view('admin.topsis.matrix_keputusan_terbobot');
    });
    Route::get('/amatrix_solusi_ideal','analisaTopsis@solusi_ideal');

    Route::group(['prefix' => 'admin'], function(){
        Route::group(["as" => "mahasiswa.", "prefix" => "mahasiswa"], function () {
            Route::get('/', 'mahasiswaController@index')->name('index');
            Route::get('/data', 'mahasiswaController@data')->name('data');
            Route::post('/add', 'mahasiswaController@store')->name('add');
            Route::post('/edit', 'mahasiswaController@edit')->name('edit');
            Route::post('/delete', 'mahasiswaController@delete')->name('delete');
        });
        Route::group(["as" => "topsis.", "prefix" => "topsis"], function () {
            Route::get('/linguistik', 'analisaTopsis@linguistik')->name('linguistik');
            Route::get('/matrix_keputusan', 'analisaTopsis@matrix_keputusan')->name('matrix_keputusan');
            Route::get('/matrix_keputusan_ternormalisasi', 'analisaTopsis@matrix_keputusan_ternormalisasi')->name('matrix_keputusan_ternormalisasi');
            Route::get('/matrix_keputusan_terbobot', 'analisaTopsis@matrix_keputusan_terbobot')->name('matrix_keputusan_terbobot');

            
        });
        Route::group(["as" => "setting.", "prefix" => "setting"], function () {
            Route::post('/bobot', 'settingController@bobot')->name('bobot');            
        });
    });

});
Route::get('/masuk',function(){
    return view('admin.login');
}); 
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
