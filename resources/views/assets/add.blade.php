@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            เพิ่มครุภัณฑ์
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">เพิ่มครุภัณฑ์</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="assetCtrl">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">เพิ่มครุภัณฑ์</h3>
                    </div>

                    <form id="frmNewAsset" name="frmNewAsset" method="post" action="{{ url('/asset/store') }}" role="form">
                        <input type="hidden" id="user" name="user" value="{{ Auth::user()->person_id }}">
                        {{ csrf_field() }}
                    
                        <div class="box-body">
                            <div class="row">
                                <div class="col-md-6">
                                    
                                    <div class="form-group" ng-class="{ 'has-error': frmNewAsset.asset_no.$error.required }">
                                        <label>เลขพัสดุ :</label>
                                        <input  type="text" 
                                                id="asset_no" .
                                                name="asset_no" 
                                                ng-model="asset.asset_no" 
                                                class="form-control"
                                                tabindex="4" required>
                                        <div class="help-block" ng-show="frmNewAsset.asset_no.$error.required">
                                            กรุณาระบุเลขพัสดุ
                                        </div>
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewAsset.asset_name.$error.required }">
                                        <label>ชื่อครุภัณฑ์ :</label>
                                        <input  type="text" 
                                                id="asset_name" 
                                                name="asset_name" 
                                                ng-model="asset.asset_name" 
                                                class="form-control"
                                                tabindex="6" required>
                                        <div class="help-block" ng-show="frmNewAsset.asset_name.$error.required">
                                            กรุณาระบุชื่อครุภัณฑ์
                                        </div>
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewAsset.amount.$error.required }">
                                        <label>จำนวน :</label>
                                        <input  type="text" 
                                                id="amount" 
                                                name="amount" 
                                                ng-model="asset.amount" 
                                                class="form-control"
                                                tabindex="8" required>
                                        <div class="help-block" ng-show="frmNewAsset.amount.$error.required">
                                            กรุณาระบุจำนวน
                                        </div>
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewAsset.asset_cate.$error.required }">
                                        <label>หมวดครุภัณฑ์ :</label>
                                        <select id="asset_cate" 
                                                name="asset_cate"
                                                ng-model="asset.asset_cate"
                                                ng-change="getAssetType();"
                                                class="form-control select2" 
                                                style="width: 100%; font-size: 12px;"
                                                tabindex="2" required>
                                            <option value="" selected="selected">-- กรุณาเลือก --</option>

                                            @foreach($cates as $cate)

                                                <option value="{{ $cate->cate_id }}">
                                                    {{ $cate->cate_no.'-'.$cate->cate_name }}
                                                </option>

                                            @endforeach
                                                
                                        </select>
                                        <div class="help-block" ng-show="frmNewAsset.asset_cate.$error.required">
                                            กรุณาเลือกหมวดครุภัณฑ์
                                        </div>
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewAsset.budget_type.$error.required }">
                                        <label>ประเภทเงิน :</label>
                                        <select id="budget_type" 
                                                name="budget_type"
                                                ng-model="asset.budget_type" 
                                                class="form-control select2" 
                                                style="width: 100%; font-size: 12px;"
                                                tabindex="2" required>
                                            <option value="" selected="selected">-- กรุณาเลือก --</option>

                                            @foreach($budgets as $budget)

                                                <option value="{{ $budget->budget_type_id }}">
                                                    {{ $budget->budget_type_name }}
                                                </option>

                                            @endforeach
                                                
                                        </select>
                                        <div class="help-block" ng-show="frmNewAsset.budget_type.$error.required">
                                            กรุณาเลือกหมวดครุภัณฑ์
                                        </div>
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewAsset.reg_no.$error.required }">
                                        <label>เลขทะเบียน :</label>
                                        <input  type="text" 
                                                id="reg_no" 
                                                name="reg_no" 
                                                ng-model="asset.reg_no"
                                                class="form-control"
                                                pattern="[0-9]{4}"
                                                tabindex="16">
                                        <div class="help-block" ng-show="frmNewAsset.reg_no.$error.required">
                                            กรุณาระบุเลขทะเบียน
                                        </div>
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewAsset.depart.$error.required }">
                                        <label>หน่วยงาน :</label>
                                        <select id="depart" 
                                                name="depart"
                                                ng-model="asset.depart" 
                                                class="form-control select2" 
                                                style="width: 100%; font-size: 12px;"
                                                tabindex="2" required>
                                            <option value="" selected="selected">-- กรุณาเลือก --</option>

                                            @foreach($departs as $depart)

                                                <option value="{{ $depart->depart_id }}">
                                                    {{ $depart->depart_name }}
                                                </option>

                                            @endforeach
                                                
                                        </select>
                                        <div class="help-block" ng-show="frmNewAsset.depart.$error.required">
                                            กรุณาเลือกหหน่วยงาน
                                        </div>
                                    </div>

                                </div><!-- /.col -->

                                <div class="col-md-6">

                                    <div class="form-group" ng-class="{ 'has-error': frmNewAsset.date_in.$error.required }">
                                        <label>วันที่รับ :</label>

                                        <div class="input-group">
                                            <div class="input-group-addon">
                                                <i class="fa fa-clock-o"></i>
                                            </div>
                                            <input  type="text" 
                                                    id="date_in" 
                                                    name="date_in" 
                                                    ng-model="asset.date_in" 
                                                    class="form-control pull-right"
                                                    tabindex="1" required>
                                        </div><!-- /.input group -->
                                        <div class="help-block" ng-show="frmNewAsset.date_in.$error.required">
                                            กรุณาเลือกวันที่ลงบัญชี
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label>ราคาหน่วยละ :</label>
                                        <input  type="text" 
                                                id="unit_price" 
                                                name="unit_price" 
                                                ng-model="asset.unit_price" 
                                                class="form-control"
                                                tabindex="3">
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewAsset.unit.$error.required }">
                                        <label>หน่วยนับ :</label>
                                        <select id="unit" 
                                                name="unit"
                                                ng-model="asset.unit" 
                                                class="form-control select2" 
                                                style="width: 100%; font-size: 12px;"
                                                tabindex="2" required>
                                            <option value="" selected="selected">-- กรุณาเลือก --</option>

                                            @foreach($units as $unit)

                                                <option value="{{ $unit->unit_id }}">
                                                    {{ $unit->unit_name }}
                                                </option>

                                            @endforeach
                                                
                                        </select>                                        
                                        <div class="help-block" ng-show="frmNewAsset.unit.$error.required">
                                            กรุณาเลือกหน่วยนับ
                                        </div>
                                    </div>                

                                    <div class="form-group" ng-class="{ 'has-error': frmNewAsset.asset_type.$error.required }">
                                        <label>ชนิดครุภัณฑ์ :</label>
                                        <select id="asset_type" 
                                                name="asset_type"
                                                ng-model="asset.asset_type" 
                                                class="form-control select2" 
                                                style="width: 100%; font-size: 12px;"
                                                tabindex="2" required>
                                            <option value="" selected="selected">-- กรุณาเลือก --</option>
                                            <option ng-repeat="(index, type) in types" value="@{{ type.type_id }}">
                                                @{{ type.type_name }}
                                            </option>
                                        </select>
                                        <div class="help-block" ng-show="frmNewAsset.asset_type.$error.required">
                                            กรุณาเลือกชนิดครุภัณฑ์
                                        </div>
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewAsset.method.$error.required }">
                                        <label>การได้มา :</label>
                                        <select id="method" 
                                                name="method"
                                                ng-model="asset.method" 
                                                class="form-control select2" 
                                                style="width: 100%; font-size: 12px;"
                                                tabindex="2" required>
                                            <option value="" selected="selected">-- กรุณาเลือก --</option>

                                            @foreach($methods as $method)

                                                <option value="{{ $method->method_id }}">
                                                    {{ $method->method_name }}
                                                </option>

                                            @endforeach
                                                
                                        </select>
                                        <div class="help-block" ng-show="frmNewAsset.method.$error.required">
                                            กรุณาเลือกหมวดครุภัณฑ์
                                        </div>
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewAsset.year.$error.required || frmNewAsset.year.$error.pattern }">
                                        <label>ปีงบประมาณ (พ.ศ.) :</label>
                                        <input  type="text" 
                                                id="year" 
                                                name="year" 
                                                ng-model="asset.year"
                                                class="form-control"
                                                pattern="[0-9]{4}"
                                                tabindex="16" required>
                                        <div class="help-block" ng-show="frmNewAsset.year.$error.required">
                                            กรุณาระบุปีงบประมาณ
                                        </div>
                                    </div>

                                    <div class="form-group" ng-class="{ 'has-error': frmNewAsset.supplier.$error.required }">
                                        <label class="control-label">ผู้จัดจำหน่าย :</label>
                                        <select id="supplier" 
                                                name="supplier"
                                                ng-model="asset.supplier" 
                                                class="form-control select2" 
                                                style="width: 100%; font-size: 12px;"
                                                tabindex="2" required>
                                            <option value="" selected="selected">-- กรุณาเลือก --</option>

                                            @foreach($suppliers as $supplier)

                                                <option value="{{ $supplier->supplier_id }}">
                                                    {{ $supplier->supplier_name }}
                                                </option>

                                            @endforeach
                                                
                                        </select>
                                        <div class="help-block" ng-show="frmNewAsset.supplier.$error.required">
                                            กรุณาเลือกผู้จัดจำหน่าย
                                        </div>
                                    </div>     
                                    
                                </div><!-- /.col -->

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>รายละเอียดเพิ่มเติม :</label>
                                        <textarea
                                            id="description" 
                                            name="description" 
                                            ng-model="asset.description" 
                                            class="form-control"
                                            tabindex="17"
                                        ></textarea>
                                    </div>
                                </div><!-- /.col -->

                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label>หมายเหตุ :</label>
                                        <textarea
                                            id="remark" 
                                            name="remark" 
                                            ng-model="asset.remark" 
                                            class="form-control"
                                            tabindex="17"
                                        ></textarea>
                                    </div>
                                </div><!-- /.col -->
                            </div><!-- /.row -->

                            <ul  class="nav nav-tabs">
                                <li class="active">
                                    <a  href="#1a" data-toggle="tab">หลักฐานการได้มา</a>
                                </li>
                            </ul>

                            <div class="tab-content clearfix">
                                <div class="tab-pane active" id="1a" style="padding: 10px;">
                                    <div class="col-md-12">       
                                        <div class="form-group" ng-class="{ 'has-error': frmNewAsset.doc_type.$error.required }">
                                            <label class="control-label">ประเภทหลักฐาน :</label>
                                            <select id="doc_type" 
                                                    name="doc_type"
                                                    ng-model="asset.doc_type" 
                                                    class="form-control select2" 
                                                    style="width: 100%; font-size: 12px;"
                                                    tabindex="2" required>
                                                <option value="" selected="selected">-- กรุณาเลือก --</option>

                                                @foreach($docs as $doc)

                                                    <option value="{{ $doc->doc_type_id }}">
                                                        {{ $doc->doc_type_name }}
                                                    </option>

                                                @endforeach
                                                    
                                            </select>
                                            <div class="help-block" ng-show="frmNewAsset.doc_type.$error.required">
                                                กรุณาเลือกประเภทหลักฐาน
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error': frmNewAsset.doc_no.$error.required }">
                                            <label>เลขที่เอกสาร :</label>
                                            <input  type="text" 
                                                    id="doc_no" 
                                                    name="doc_no" 
                                                    ng-model="asset.doc_no"
                                                    class="form-control"
                                                    tabindex="12" required>
                                            <div class="help-block" ng-show="frmNewAsset.doc_no.$error.required">
                                                กรุณาระบุเลขที่เอกสาร
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group" ng-class="{ 'has-error': frmNewAsset.doc_date.$error.required }">
                                            <label>ลงวันที่ :</label>
                                            <div class="input-group">
                                                <div class="input-group-addon">
                                                    <i class="fa fa-clock-o"></i>
                                                </div>
                                                <input  type="text" 
                                                        id="doc_date" 
                                                        name="doc_date" 
                                                        ng-model="asset.doc_date" 
                                                        class="form-control pull-right"
                                                        tabindex="5" required>
                                            </div><!-- /.input group -->
                                            <div class="help-block" ng-show="frmNewAsset.doc_date.$error.pattern">
                                                กรุณาเลือกวันที่หลักฐานการได้มา
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            
                        </div><!-- /.box-body -->
                  
                        <div class="box-footer clearfix">
                            <button ng-click="store($event, frmNewAsset)" class="btn btn-success pull-right">
                                บันทึก
                            </button>
                        </div><!-- /.box-footer -->
                    </form>

                </div><!-- /.box -->

            </div><!-- /.col -->
        </div><!-- /.row -->

    </section>

    <script>
        $(function () {
            //Initialize Select2 Elements
            $('.select2').select2()

            $('#date_in').datepicker({
                autoclose: true,
                language: 'th',
                format: 'dd/mm/yyyy',
                thaiyear: true
            });

            $('#doc_date').datepicker({
                autoclose: true,
                language: 'th',
                format: 'dd/mm/yyyy',
                thaiyear: true
            });
        });
    </script>

@endsection