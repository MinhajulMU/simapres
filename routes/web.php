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



Route::get('/tes','analisaTopsis@get_positif_distance'); 
Route::get('/tes2',function(){
    $users = DB::table('mahasiswa')->select(DB::raw('SUM(prestasi) as jumlah'))->first();
    return $users->jumlah;
});
Route::group(['as' =>'admin.','middleware'=> 'auth'],function(){
    Route::get('/', function () {
        $data['mahasiswa'] = count(\App\Model\Mahasiswa::all());
        $data['fmipa'] = count(\App\Model\Mahasiswa::where('fakultas','FMIPA')->get());
        $data['ft'] = count(\App\Model\Mahasiswa::where('fakultas','FT')->get());
        $data['fbs'] = count(\App\Model\Mahasiswa::where('fakultas','FBS')->get());
        $data['fik'] = count(\App\Model\Mahasiswa::where('fakultas','FIK')->get());
        $data['fe'] = count(\App\Model\Mahasiswa::where('fakultas','FE')->get());
        $data['fis'] = count(\App\Model\Mahasiswa::where('fakultas','FIS')->get());
        $data['fip'] = count(\App\Model\Mahasiswa::where('fakultas','FIP')->get());
        $data['fh'] = count(\App\Model\Mahasiswa::where('fakultas','FH')->get());
        return view('admin.dashboard',$data);
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
    Route::get('/ajarak_solusi_positif', function () {
        return view('admin.topsis.jarak_solusi_positif');
    });
    Route::get('/ajarak_solusi_negatif', function () {
        return view('admin.topsis.jarak_solusi_negatif');
    });
    Route::get('/anilai_preferensi', function () {
        return view('admin.topsis.nilai_preferensi');
    });
    Route::get('/ahasil_rekomendasi', function () {
        return view('admin.topsis.hasil_rekomendasi');
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
            Route::get('/jarak_solusi_positif', 'analisaTopsis@jarak_solusi_positif')->name('jarak_solusi_positif');
            Route::get('/jarak_solusi_negatif', 'analisaTopsis@jarak_solusi_negatif')->name('jarak_solusi_negatif');
            Route::get('/nilai_preferensi', 'analisaTopsis@nilai_preferensi')->name('nilai_preferensi');

            
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
