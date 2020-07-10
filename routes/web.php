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
    Route::get('/carros/{orderBy?}', 'CarController@index')->name('cars.index');

    Route::get('/novo-carro', 'CarController@create')->name('cars.create');

    Route::get('/editar_carro/{id}', 'CarController@edit')->name('cars.edit');

    Route::post('/novo-carro', 'CarController@store')->name('cars.store');

    Route::put('/editar_carro/{id}', 'CarController@update')->name('cars.update');

    Route::delete('/carro/{id}', 'CarController@delete');

    //If a car exists
    Route::get('/car_exists/{model}/{id?}', 'CarController@car_exists');

    //Fill inputs when a car was chosen
    Route::get('/car_details/{id}', 'CarController@car_details');

    //Car Infinite Pagination
    Route::get('/car_pagination/{offset}', 'CarController@car_pagination');

    //Car Search
    Route::get('/car_search/{input}', 'CarController@car_search');

    /*
     * Brands / Montadoras
     */

    Route::get('/montadoras', 'CarController@brands')->name('brands.index');

    Route::get('/brand_pagination/{offset}', 'CarController@brand_pagination');

    Route::get('/brand_exists/{name}', 'CarController@brand_exists');

    Route::post('/brand', 'CarController@brand_store');

    Route::put('/brand/{id}', 'CarController@brand_update');

    Route::get('/brand_search/{input}', 'CarController@brand_search');



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
     * Config
     */
    Route::get('/configuracoes', 'ConfigController@index')->name('config.index');

    Route::post('/pagination', 'ConfigController@set_pagination');

    /*
     * Peças / Parts (Vínculo das peças com os carros)
     */
    Route::get('/pecas/{orderBy?}', 'PartsController@index')->name('parts.index');

    Route::get('/criar-peca', 'PartsController@create')->name('parts.create');

    Route::get('/editar-peca/{id}', 'PartsController@edit')->name('parts.edit');

    Route::post('/peca', 'PartsController@store')->name('parts.store');

    Route::put('/peca/{id}', 'PartsController@update')->name('parts.update');

    Route::get('/system_parts/{system_id}', 'PartsController@system_parts');

    //Retira o vínculo peça x carro
    Route::delete('/peca/{id}', 'PartsController@delete');

    Route::get('/list_cars_by_brand/{id}', 'PartsController@list_cars_by_brand');

    Route::get('/part_exists/{name}', 'PartsController@part_exists');

    Route::post('store_part_name', 'PartsController@store_part_name');

    Route::post('/store_part_brand', 'PartsController@store_part_brand');

    Route::post('/store_part', 'PartsController@store_part')->name('store.part');

    Route::put('/update_part/{id}', 'PartsController@update_part')->name('update.part');

    /*
     * Parts_name / Cadastro das peças
     */
    //List all parts // Listar todas as peças
    Route::get('/listar_pecas/{orderBy?}', 'PartsController@list_parts')->name('parts.list');



    //Excluir a peça selecionada, não confundir com a desvinculação da peça com o carro
    Route::delete('part_name/{id}', 'PartsController@delete_part_name');


});

Auth::routes();

//Cadastro de Peça // New Part
Route::post('/part_name', 'PartsController@store_part_name');

//Editar Peça // Edit Part
Route::put('/part_name/{id}', 'PartsController@update_part_name');

//Testes

Route::get('get_session', 'TesteController@get_session');

Route::get('/domains/{length?}', "TesteController@domains");

Route::get('/admin-login', function (){
    return view('auth.login-admin');
});

