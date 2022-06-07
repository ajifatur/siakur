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

Route::get('/', function () {
    return view('welcome');
});

Route::group(['middleware' => ['faturhelper.admin']], function() {
    // Guru
    Route::get('/admin/guru', 'GuruController@index')->name('admin.guru.index');
    Route::get('/admin/guru/create', 'GuruController@create')->name('admin.guru.create');
    Route::post('/admin/guru/store', 'GuruController@store')->name('admin.guru.store');
    Route::get('/admin/guru/edit/{id}', 'GuruController@edit')->name('admin.guru.edit');
    Route::post('/admin/guru/update', 'GuruController@update')->name('admin.guru.update');
    Route::post('/admin/guru/delete', 'GuruController@delete')->name('admin.guru.delete');

    // Siswa
    Route::get('/admin/siswa', 'SiswaController@index')->name('admin.siswa.index');
    Route::get('/admin/siswa/create', 'SiswaController@create')->name('admin.siswa.create');
    Route::post('/admin/siswa/store', 'SiswaController@store')->name('admin.siswa.store');
    Route::get('/admin/siswa/edit/{id}', 'SiswaController@edit')->name('admin.siswa.edit');
    Route::post('/admin/siswa/update', 'SiswaController@update')->name('admin.siswa.update');
    Route::post('/admin/siswa/delete', 'SiswaController@delete')->name('admin.siswa.delete');

    // Kelas
    Route::get('/admin/kelas', 'KelasController@index')->name('admin.kelas.index');
    Route::get('/admin/kelas/create', 'KelasController@create')->name('admin.kelas.create');
    Route::post('/admin/kelas/store', 'KelasController@store')->name('admin.kelas.store');
    Route::get('/admin/kelas/edit/{id}', 'KelasController@edit')->name('admin.kelas.edit');
    Route::post('/admin/kelas/update', 'KelasController@update')->name('admin.kelas.update');
    Route::post('/admin/kelas/delete', 'KelasController@delete')->name('admin.kelas.delete');

    // Jurusan
    Route::get('/admin/jurusan', 'JurusanController@index')->name('admin.jurusan.index');
    Route::get('/admin/jurusan/create', 'JurusanController@create')->name('admin.jurusan.create');
    Route::post('/admin/jurusan/store', 'JurusanController@store')->name('admin.jurusan.store');
    Route::get('/admin/jurusan/edit/{id}', 'JurusanController@edit')->name('admin.jurusan.edit');
    Route::post('/admin/jurusan/update', 'JurusanController@update')->name('admin.jurusan.update');
    Route::post('/admin/jurusan/delete', 'JurusanController@delete')->name('admin.jurusan.delete');

    // Rombel
    Route::get('/admin/rombel', 'RombelController@index')->name('admin.rombel.index');
    Route::get('/admin/rombel/create', 'RombelController@create')->name('admin.rombel.create');
    Route::post('/admin/rombel/store', 'RombelController@store')->name('admin.rombel.store');
    Route::get('/admin/rombel/edit/{id}', 'RombelController@edit')->name('admin.rombel.edit');
    Route::post('/admin/rombel/update', 'RombelController@update')->name('admin.rombel.update');
    Route::post('/admin/rombel/delete', 'RombelController@delete')->name('admin.rombel.delete');

    // Mapel
    Route::get('/admin/mapel', 'MapelController@index')->name('admin.mapel.index');
    Route::get('/admin/mapel/create', 'MapelController@create')->name('admin.mapel.create');
    Route::post('/admin/mapel/store', 'MapelController@store')->name('admin.mapel.store');
    Route::get('/admin/mapel/edit/{id}', 'MapelController@edit')->name('admin.mapel.edit');
    Route::post('/admin/mapel/update', 'MapelController@update')->name('admin.mapel.update');
    Route::post('/admin/mapel/delete', 'MapelController@delete')->name('admin.mapel.delete');

    // Tahun Akademik
    Route::get('/admin/tahun-akademik', 'TahunAkademikController@index')->name('admin.tahun-akademik.index');
    Route::get('/admin/tahun-akademik/create', 'TahunAkademikController@create')->name('admin.tahun-akademik.create');
    Route::post('/admin/tahun-akademik/store', 'TahunAkademikController@store')->name('admin.tahun-akademik.store');
    Route::get('/admin/tahun-akademik/edit/{id}', 'TahunAkademikController@edit')->name('admin.tahun-akademik.edit');
    Route::post('/admin/tahun-akademik/update', 'TahunAkademikController@update')->name('admin.tahun-akademik.update');
    Route::post('/admin/tahun-akademik/delete', 'TahunAkademikController@delete')->name('admin.tahun-akademik.delete');

    // Kurikulum
    Route::get('/admin/kurikulum', 'KurikulumController@index')->name('admin.kurikulum.index');
    Route::get('/admin/kurikulum/create', 'KurikulumController@create')->name('admin.kurikulum.create');
    Route::post('/admin/kurikulum/store', 'KurikulumController@store')->name('admin.kurikulum.store');
    Route::get('/admin/kurikulum/edit/{id}', 'KurikulumController@edit')->name('admin.kurikulum.edit');
    Route::post('/admin/kurikulum/update', 'KurikulumController@update')->name('admin.kurikulum.update');
    Route::post('/admin/kurikulum/delete', 'KurikulumController@delete')->name('admin.kurikulum.delete');

    // JP
    Route::get('/admin/jp', 'JPController@index')->name('admin.jp.index');
    Route::get('/admin/jp/create', 'JPController@create')->name('admin.jp.create');
    Route::post('/admin/jp/store', 'JPController@store')->name('admin.jp.store');
    Route::get('/admin/jp/edit/{id}', 'JPController@edit')->name('admin.jp.edit');
    Route::post('/admin/jp/update', 'JPController@update')->name('admin.jp.update');
    Route::post('/admin/jp/delete', 'JPController@delete')->name('admin.jp.delete');

    // Guru Mapel
    Route::get('/admin/guru-mapel', 'GuruMapelController@index')->name('admin.guru-mapel.index');
    Route::get('/admin/guru-mapel/create', 'GuruMapelController@create')->name('admin.guru-mapel.create');
    Route::post('/admin/guru-mapel/store', 'GuruMapelController@store')->name('admin.guru-mapel.store');
    Route::get('/admin/guru-mapel/edit/{id}', 'GuruMapelController@edit')->name('admin.guru-mapel.edit');
    Route::post('/admin/guru-mapel/update', 'GuruMapelController@update')->name('admin.guru-mapel.update');
    Route::post('/admin/guru-mapel/delete', 'GuruMapelController@delete')->name('admin.guru-mapel.delete');
});

\Ajifatur\Helpers\RouteExt::auth();
\Ajifatur\Helpers\RouteExt::admin();