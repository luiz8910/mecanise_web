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


Route::get('/login', 'Auth\LoginController@login_page')->name('login');

Route::post('/do_login', 'Auth\LoginController@login')->name('login.post');

Route::group(['middleware' => 'auth'], function (){

    /**
     * Dashboard
     */
    Route::get('/', 'CarController@index')->name('home.index');

    Route::get('/home', 'CarController@index');

    /**
     * Crud Users
     */
    Route::get('/usuarios', 'PersonController@index')->name('person.index');

    Route::get('/tabela-usuarios', 'PersonController@index_table')->name('person.table');

    Route::get('/criar-usuario', 'PersonController@create')->name('person.create');

    Route::get('/editar-usuario/{id}', 'PersonController@edit')->name('person.edit');

    Route::post('/person', 'PersonController@store')->name('person.store');

    Route::put('/person/{id}', 'PersonController@update')->name('person.update');

    Route::delete('/person/{id}', 'PersonController@delete');

    /**
     * Crud Vehicles
     */
    Route::get('/veiculos', 'VehicleController@index')->name('vehicle.index');

    Route::get('/criar-veiculo', 'VehicleController@create')->name('vehicle.create');

    Route::get('/editar-veiculo/{id}', 'VehicleController@edit')->name('vehicle.edit');

    Route::post('/vehicle', 'VehicleController@store')->name('vehicle.store');

    Route::put('/vehicle/{id}', 'VehicleController@update')->name('vehicle.update');

    Route::delete('/vehicle/{id}', 'VehicleController@delete');

    Route::get('/vehicle_by_owner/{id}', 'VehicleController@vehicle_by_owner')->name('vehicle.by.owner');

    Route::get('/search-vehicles/{input}', 'VehicleController@search');


    /**
     * Crud Products
     */
    Route::get('/produtos', 'ProductController@index')->name('product.index');

    //List products by category
    Route::get('/produtos_categoria/{id}', 'ProductController@list_by_category')->name('product.by.category');

    Route::get('/novo_produto', 'ProductController@create')->name('product.create');

    Route::get('/editar_produto/{id}', 'ProductController@edit')->name('product.edit');

    Route::post('/product', 'ProductController@store')->name('product.store');

    Route::put('/product/{id}', 'ProductController@update')->name('product.update');

    Route::delete('/product/{id}', 'ProductController@delete')->name('product.delete');

    /**
     * Crud Services
     */
    Route::get('/servicos', 'ServiceController@index')->name('service.index');

    Route::get('/novo_servico', 'ServiceController@create')->name('service.create');

    Route::get('/editar_servico/{id}', 'ServiceController@edit')->name('service.edit');

    Route::post('/service', 'ServiceController@store')->name('service.store');

    Route::put('/service/{id}', 'ServiceController@update')->name('service.update');

    Route::delete('/service/{id}', 'ServiceController@delete')->name('service.delete');

    /**
     * Crud Diagnóstico
     */
    Route::get('/diagnosticos', 'DiagnosisController@index')->name('diagnosis.index');

    Route::get('/novo_diagnostico', 'DiagnosisController@create')->name('diagnosis.create');

    Route::get('/editar_diagnostico/{id}', 'DiagnosisController@edit')->name('diagnosis.edit');

    Route::post('/diagnosis', 'DiagnosisController@store')->name('diagnosis.store');

    Route::put('/diagnosis/{id}', 'DiagnosisController@update')->name('diagnosis.update');

    Route::delete('/diagnosis/{id}', 'DiagnosisController@delete')->name('diagnosis.delete');

    /**
     * Crud Checklist
     */
    Route::get('/checklist', 'ChecklistController@index')->name('checklist.index');

    Route::get('/checklist_veiculo/{id}', 'ChecklistController@list_by_vehicle')->name('checklist.by.vehicle');

    Route::get('/novo_checklist', 'ChecklistController@create')->name('checklist.create');

    Route::get('/editar_checklist/{id}', 'ChecklistController@edit')->name('checklist.edit');

    Route::post('/checklist', 'ChecklistController@store')->name('checklist.store');

    Route::put('/checklist/{id}', 'ChecklistController@update')->name('checklist.update');

    Route::delete('/checklist/{id}', 'ChecklistController@delete')->name('checklist.delete');

    /**
     * Cars
     */
    Route::get('/carros', 'CarController@index')->name('cars.index');

    Route::get('/novo-carro', 'CarController@create')->name('cars.create');

    Route::get('/editar_carro/{id}', 'CarController@edit')->name('cars.edit');

    Route::post('/novo-carro', 'CarController@store')->name('cars.store');

    Route::put('/editar_carro/{id}', 'CarController@update')->name('cars.update');

    Route::delete('/carro/{id}', 'CarController@delete');

    Route::get('/car_exists/{model}/{id?}', 'CarController@car_exists');

    Route::get('/car_details/{id}', 'CarController@car_details');

    /*
     * Ordens de Serviço / Orders
     */
    Route::get('/os/{filter?}', 'OrderController@index')->name('order.index');

    Route::get('/criar-os', 'OrderController@create')->name('order.create');

    Route::get('/editar-os/{id}', 'OrderController@edit')->name('order.edit');

    Route::post('/os', 'OrderController@store')->name('order.store');

    Route::put('/os/{id}', 'OrderController@update')->name('order.update');

    Route::delete('/os/{id}', 'OrderController@delete');

    Route::get('/get_vehicles/{owner_id}', 'OrderController@get_vehicles');

    /*
     * Peças / Pastilhas de Freio
     */

});

Auth::routes();


//Testes

Route::get('get_session', 'TesteController@get_session');

Route::get('/domains/{length?}', "TesteController@domains");
