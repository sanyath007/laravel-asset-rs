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

Route::get('/', 'Auth\LoginController@showLogin');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::group(['middleware' => 'web'], function() {
    /** ============= Authentication ============= */
    Route::get('/auth/login', 'Auth\LoginController@showLogin');

    Route::post('/auth/signin', 'Auth\LoginController@doLogin');

    Route::get('/auth/logout', 'Auth\LoginController@doLogout');

    Route::get('/auth/register', 'Auth\RegisterController@register');

    Route::post('/auth/signup', 'Auth\RegisterController@create');
});

Route::group(['middleware' => ['web','auth']], function () {
    // Route::get('approve/list', 'ApprovementController@list');
    // Route::get('approve/search/{searchKey}', 'ApprovementController@search');
    // Route::get('approve/get-approve/{appId}', 'ApprovementController@getById');
    // Route::get('approve/add', 'ApprovementController@add');
    // Route::post('approve/store', 'ApprovementController@store');
    // Route::get('approve/detail/{appId}', 'ApprovementController@detail');
    // Route::get('approve/edit/{appId}', 'ApprovementController@edit');
    // Route::put('approve/update', 'ApprovementController@update');
    // Route::delete('approve/delete/{appId}', 'ApprovementController@delete');

    // Route::get('payment/list', 'PaymentController@list');
    // Route::get('payment/search/{searchKey}', 'PaymentController@search');
    // Route::get('payment/get-payment/{appId}', 'PaymentController@getById');
    // Route::get('payment/add', 'PaymentController@add');
    // Route::post('payment/store', 'PaymentController@store');
    // Route::get('payment/detail/{appId}', 'PaymentController@detail');
    // Route::get('payment/edit/{appId}', 'PaymentController@edit');
    // Route::put('payment/update', 'PaymentController@update');
    // Route::delete('payment/delete/{appId}', 'PaymentController@delete');

    /** Asset */
    Route::get('asset/list', 'AssetController@list');
    Route::get('asset/search/{cate}/{type}/{status}/{searchKey}', 'AssetController@search');
    Route::get('asset/get-asset/{debtId}', 'AssetController@getById');
    Route::get('asset/add', 'AssetController@add');
    Route::post('asset/store', 'AssetController@store');
    Route::get('asset/edit/{creditor}/{debtId}', 'AssetController@edit');
    Route::put('asset/update', 'AssetController@update');
    Route::delete('asset/delete/{debtId}', 'AssetController@delete');
    Route::get('asset/discharge', 'AssetController@discharge');
    Route::post('asset/discharge', 'AssetController@doDischarge');
    Route::post('/asset/validate', 'AssetController@formValidate');

    /** Asset Type */
    Route::get('asset-type/list', 'AssetTypeController@list');
	Route::get('asset-type/search/{searchKey}', 'AssetTypeController@search');
    Route::get('asset-type/get-asset-type/{typeId}', 'AssetTypeController@getById');
    Route::get('asset-type/get-ajax-all/{cateId}', 'AssetTypeController@getAjexAll');
    Route::get('asset-type/add', 'AssetTypeController@add');
    Route::post('asset-type/store', 'AssetTypeController@store');
    Route::get('asset-type/edit/{typeId}', 'AssetTypeController@edit');
    Route::put('asset-type/update', 'AssetTypeController@update');
    Route::delete('asset-type/delete/{typeId}', 'AssetTypeController@delete');
    Route::post('/asset-type/validate', 'AssetTypeController@formValidate');

    /** Asset Category */
    Route::get('asset-cate/list', 'AssetCategoryController@list');
    Route::get('asset-cate/search/{searchKey}', 'AssetCategoryController@search');
    Route::get('asset-cate/get-asset-cate/{cateeId}', 'AssetCategoryController@getById');
    Route::get('asset-cate/add', 'AssetCategoryController@add');
    Route::post('asset-cate/store', 'AssetCategoryController@store');
    Route::get('asset-cate/edit/{cateeId}', 'AssetCategoryController@edit');
    Route::put('asset-cate/update', 'AssetCategoryController@update');
    Route::delete('asset-cate/delete/{cateeId}', 'AssetCategoryController@delete');
    Route::post('/asset-cate/validate', 'AssetCategoryController@formValidate');

    /** Asset Unit */
    Route::get('asset-unit/list', 'AssetUnitController@list');
    Route::get('asset-unit/search/{searchKey}', 'AssetUnitController@search');
    Route::get('asset-unit/get-asset-unit/{unitId}', 'AssetUnitController@getById');
    Route::get('asset-unit/add', 'AssetUnitController@add');
    Route::post('asset-unit/store', 'AssetUnitController@store');
    Route::get('asset-unit/edit/{unitId}', 'AssetUnitController@edit');
    Route::put('asset-unit/update', 'AssetUnitController@update');
    Route::delete('asset-unit/delete/{unitId}', 'AssetUnitController@delete');
    Route::post('/asset-unit/validate', 'AssetUnitController@formValidate');

    /** Supplier */
    Route::get('supplier/list', 'SupplierController@list');
    Route::get('supplier/search/{searchKey}', 'SupplierController@search');
    Route::get('supplier/get-supplier/{creditorId}', 'SupplierController@getById');
    Route::get('supplier/add', 'SupplierController@add');
    Route::post('supplier/store', 'SupplierController@store');
    Route::get('supplier/edit/{creditorId}', 'SupplierController@edit');
    Route::put('supplier/update', 'SupplierController@update');
    Route::delete('supplier/delete/{creditorId}', 'SupplierController@delete');

    /** Report */
    Route::get('report/debt-creditor/list', 'ReportController@debtCreditor');    
    Route::get('report/debt-creditor/rpt/{creditor}/{sdate}/{edate}/{showall}', 'ReportController@debtCreditorRpt');
    Route::get('report/debt-creditor-excel/{creditor}/{sdate}/{edate}/{showall}', 'ReportController@debtCreditorExcel');     
    Route::get('report/debt-debttype/list', 'ReportController@debtDebttype');    
    Route::get('report/debt-debttype/rpt/{debtType}/{sdate}/{edate}/{showall}', 'ReportController@debtDebttypeRpt');
    Route::get('report/debt-debttype-excel/{debttype}/{sdate}/{edate}/{showall}', 'ReportController@debtDebttypeExcel');
    Route::get('report/debt-chart/{creditorId}', 'ReportController@debtChart');     
    Route::get('report/sum-month-chart/{month}', 'ReportController@sumMonth');     
    Route::get('report/sum-year-chart/{month}', 'ReportController@sumYear');     
});
