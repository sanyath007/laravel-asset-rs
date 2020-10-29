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
    Route::get('approve/list', 'ApprovementController@list');
    Route::get('approve/search/{searchKey}', 'ApprovementController@search');
    Route::get('approve/get-approve/{appId}', 'ApprovementController@getById');
    Route::get('approve/add', 'ApprovementController@add');
    Route::post('approve/store', 'ApprovementController@store');
    Route::get('approve/detail/{appId}', 'ApprovementController@detail');
    Route::get('approve/edit/{appId}', 'ApprovementController@edit');
    Route::put('approve/update', 'ApprovementController@update');
    Route::delete('approve/delete/{appId}', 'ApprovementController@delete');

    Route::get('payment/list', 'PaymentController@list');
    Route::get('payment/search/{searchKey}', 'PaymentController@search');
    Route::get('payment/get-payment/{appId}', 'PaymentController@getById');
    Route::get('payment/add', 'PaymentController@add');
    Route::post('payment/store', 'PaymentController@store');
    Route::get('payment/detail/{appId}', 'PaymentController@detail');
    Route::get('payment/edit/{appId}', 'PaymentController@edit');
    Route::put('payment/update', 'PaymentController@update');
    Route::delete('payment/delete/{appId}', 'PaymentController@delete');

    Route::get('account/arrear', 'AccountController@arrear');    
    Route::get('account/arrear-rpt/{debttype}/{creditor}/{sdate}/{edate}/{showall}', 'AccountController@arrearRpt');     
    Route::get('account/arrear-excel/{debttype}/{creditor}/{sdate}/{edate}/{showall}', 'AccountController@arrearExcel'); 
    Route::get('account/creditor-paid', 'AccountController@creditorPaid');    
    Route::get('account/creditor-paid-rpt/{creditor}/{sdate}/{edate}/{showall}', 'AccountController@creditorPaidRpt');     
    Route::get('account/creditor-paid-excel/{creditor}/{sdate}/{edate}/{showall}', 'AccountController@creditorPaidExcel');
    Route::get('account/ledger/{sdate}/{edate}/{showall}', 'AccountController@ledger');     
    Route::get('account/ledger-excel/{sdate}/{edate}/{showall}', 'AccountController@ledgerExcel');
    Route::get('account/ledger-debttype/{sdate}/{edate}/{showall}', 'AccountController@ledgerDebttype');     
    Route::get('account/ledger-debttype-excel/{sdate}/{edate}/{showall}', 'AccountController@ledgerDebttypeExcel'); 

    Route::get('supplier/list', 'SupplierController@list');
    Route::get('supplier/search/{searchKey}', 'SupplierController@search');
    Route::get('supplier/get-supplier/{creditorId}', 'SupplierController@getById');
    Route::get('supplier/add', 'SupplierController@add');
    Route::post('supplier/store', 'SupplierController@store');
    Route::get('supplier/edit/{creditorId}', 'SupplierController@edit');
    Route::put('supplier/update', 'SupplierController@update');
    Route::delete('supplier/delete/{creditorId}', 'SupplierController@delete');

    Route::get('asset/list', 'AssetController@list');
    Route::get('asset/search/{cate}/{type}/{status}/{searchKey}', 'AssetController@search');
    Route::get('asset/get-asset/{debtId}', 'AssetController@getById');
    Route::get('asset/add/{creditor}', 'AssetController@add');
    Route::post('asset/store', 'AssetController@store');
    Route::get('asset/edit/{creditor}/{debtId}', 'AssetController@edit');
    Route::put('asset/update', 'AssetController@update');
    Route::delete('asset/delete/{debtId}', 'AssetController@delete');
    Route::post('asset/setzero', 'AssetController@setZero');
    Route::get('asset/{creditor}/list', 'AssetController@supplierDebt');

    Route::get('asset-type/list', 'AssetTypeController@list');
	Route::get('asset-type/search/{searchKey}', 'AssettypeController@search');
    Route::get('asset-type/get-asset-type/{typeId}', 'AssettypeController@getById');
    Route::get('asset-type/add', 'AssetTypeController@add');
    Route::post('asset-type/store', 'AssettypeController@store');
    Route::get('asset-type/edit/{typeId}', 'AssettypeController@edit');
    Route::put('asset-type/update', 'AssettypeController@update');
    Route::delete('asset-type/delete/{typeId}', 'AssettypeController@delete');

    Route::get('asset-cate/list', 'AssetCategoryController@list');
    Route::get('asset-cate/search/{searchKey}', 'AssetCategoryController@search');
    Route::get('asset-cate/get-asset-cate/{cateeId}', 'AssetCategoryController@getById');
    Route::get('asset-cate/add', 'AssetCategoryController@add');
    Route::post('asset-cate/store', 'AssetCategoryController@store');
    Route::get('asset-cate/edit/{cateeId}', 'AssetCategoryController@edit');
    Route::put('asset-cate/update', 'AssetCategoryController@update');
    Route::delete('asset-cate/delete/{cateeId}', 'AssetCategoryController@delete');

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