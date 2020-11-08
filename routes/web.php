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
    Route::get('deprec/list', 'DepreciationController@list');
    Route::get('deprec/search', 'DepreciationController@search');
    Route::get('deprec/get-deprec/{appId}', 'DepreciationController@getById');
    Route::get('deprec/add', 'DepreciationController@add');
    Route::post('deprec/store', 'DepreciationController@store');
    Route::get('deprec/detail/{appId}', 'DepreciationController@detail');
    Route::get('deprec/edit/{appId}', 'DepreciationController@edit');
    Route::put('deprec/update', 'DepreciationController@update');
    Route::delete('deprec/delete/{appId}', 'DepreciationController@delete');

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
    Route::post('/asset/validate', 'AssetController@formValidate');
    Route::get('asset/list', 'AssetController@list');
    Route::get('asset/search/{cate}/{type}/{status}/{searchKey}', 'AssetController@search');
    Route::get('asset/get-ajax-all', 'AssetController@getAjexAll');
    Route::get('asset/get-ajax-byid/{assetId}', 'AssetController@getById');
    Route::get('asset/add', 'AssetController@add');
    Route::post('asset/store', 'AssetController@store');
    Route::get('asset/edit/{assetId}', 'AssetController@edit');
    Route::put('asset/update', 'AssetController@update');
    Route::delete('asset/delete/{assetId}', 'AssetController@delete');
    Route::get('asset/discharge', 'AssetController@discharge');
    Route::post('asset/discharge', 'AssetController@doDischarge');
    
    /** Parcel */
    Route::post('/parcel/validate', 'ParcelController@formValidate');
    Route::get('parcel/list', 'ParcelController@list');
    Route::get('parcel/search/{parcelType}/{searchKey}', 'ParcelController@search');
    Route::get('parcel/get-ajax-all', 'ParcelController@getAjexAll');
    Route::get('parcel/get-ajax-byid/{parcelId}', 'ParcelController@getById');
    Route::get('parcel/get-ajax-no/{assetType}', 'ParcelController@getNo');
    Route::get('parcel/add', 'ParcelController@add');
    Route::post('parcel/store', 'ParcelController@store');
    Route::get('parcel/edit/{parcelId}', 'ParcelController@edit');
    Route::put('parcel/update', 'ParcelController@update');
    Route::delete('parcel/delete/{parcelId}', 'ParcelController@delete');
    Route::get('parcel/discharge', 'ParcelController@discharge');
    Route::post('parcel/discharge', 'ParcelController@doDischarge');

    /** Asset Type */
    Route::post('/asset-type/validate', 'AssetTypeController@formValidate');
    Route::get('asset-type/list', 'AssetTypeController@list');
	Route::get('asset-type/search/{searchKey}', 'AssetTypeController@search');
    Route::get('asset-type/get-ajax-byid/{typeId}', 'AssetTypeController@getById');
    Route::get('asset-type/get-ajax-all/{cateId}', 'AssetTypeController@getAjexAll');
    Route::get('asset-type/add', 'AssetTypeController@add');
    Route::post('asset-type/store', 'AssetTypeController@store');
    Route::get('asset-type/edit/{typeId}', 'AssetTypeController@edit');
    Route::put('asset-type/update', 'AssetTypeController@update');
    Route::delete('asset-type/delete/{typeId}', 'AssetTypeController@delete');

    /** Asset Category */
    Route::post('/asset-cate/validate', 'AssetCategoryController@formValidate');
    Route::get('asset-cate/list', 'AssetCategoryController@list');
    Route::get('asset-cate/search/{searchKey}', 'AssetCategoryController@search');
    Route::get('asset-cate/get-asset-cate/{cateeId}', 'AssetCategoryController@getById');
    Route::get('asset-cate/add', 'AssetCategoryController@add');
    Route::post('asset-cate/store', 'AssetCategoryController@store');
    Route::get('asset-cate/edit/{cateeId}', 'AssetCategoryController@edit');
    Route::put('asset-cate/update', 'AssetCategoryController@update');
    Route::delete('asset-cate/delete/{cateeId}', 'AssetCategoryController@delete');

    /** Asset Unit */
    Route::post('/asset-unit/validate', 'AssetUnitController@formValidate');
    Route::get('asset-unit/list', 'AssetUnitController@list');
    Route::get('asset-unit/search/{searchKey}', 'AssetUnitController@search');
    Route::get('asset-unit/get-asset-unit/{unitId}', 'AssetUnitController@getById');
    Route::get('asset-unit/add', 'AssetUnitController@add');
    Route::post('asset-unit/store', 'AssetUnitController@store');
    Route::get('asset-unit/edit/{unitId}', 'AssetUnitController@edit');
    Route::put('asset-unit/update', 'AssetUnitController@update');
    Route::delete('asset-unit/delete/{unitId}', 'AssetUnitController@delete');


    /** Asset Group */
    Route::post('/asset-group/validate', 'AssetGroupController@formValidate');
    Route::get('asset-group/list', 'AssetGroupController@list');
	Route::get('asset-group/search/{searchKey}', 'AssetGroupController@search');
    Route::get('asset-group/get-ajax-byid/{typeId}', 'AssetGroupController@getById');
    Route::get('asset-group/get-ajax-all/{cateId}', 'AssetGroupController@getAjexAll');
    Route::get('asset-group/add', 'AssetGroupController@add');
    Route::post('asset-group/store', 'AssetGroupController@store');
    Route::get('asset-group/edit/{typeId}', 'AssetGroupController@edit');
    Route::put('asset-group/update', 'AssetGroupController@update');
    Route::delete('asset-group/delete/{typeId}', 'AssetGroupController@delete');

    /** Asset Class */
    Route::post('/asset-class/validate', 'AssetClassController@formValidate');
    Route::get('asset-class/list', 'AssetClassController@list');
    Route::get('asset-class/search/{searchKey}', 'AssetClassController@search');
    Route::get('asset-class/get-asset-class/{cateeId}', 'AssetClassController@getById');
    Route::get('asset-class/add', 'AssetClassController@add');
    Route::post('asset-class/store', 'AssetClassController@store');
    Route::get('asset-class/edit/{cateeId}', 'AssetClassController@edit');
    Route::put('asset-class/update', 'AssetClassController@update');
    Route::delete('asset-class/delete/{cateeId}', 'AssetClassController@delete');

    /** Deprec Type */
    Route::post('/deprec-type/validate', 'DeprecTypeController@formValidate');
    Route::get('deprec-type/list', 'DeprecTypeController@list');
	Route::get('deprec-type/search/{searchKey}', 'DeprecTypeController@search');
    Route::get('deprec-type/get-ajax-byid/{typeId}', 'DeprecTypeController@getById');
    Route::get('deprec-type/get-ajax-all', 'DeprecTypeController@getAjexAll');
    Route::get('deprec-type/add', 'DeprecTypeController@add');
    Route::post('deprec-type/store', 'DeprecTypeController@store');
    Route::get('deprec-type/edit/{typeId}', 'DeprecTypeController@edit');
    Route::put('deprec-type/update', 'DeprecTypeController@update');
    Route::delete('deprec-type/delete/{typeId}', 'DeprecTypeController@delete');

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
