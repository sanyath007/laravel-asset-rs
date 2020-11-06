@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            แก้ไขประเภทหนี้ : {{ $type->type_id }}
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">แก้ไขประเภทหนี้</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="assetTypeCtrl" ng-init="getAssettype('{{ $type->type_id }}')">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">ฟอร์มแก้ไขประเภทหนี้</h3>
                    </div>

                    <form id="frmEditAssetType" name="frmEditAssetType" method="post" action="{{ url('/type/update') }}" role="form">
                        <input type="hidden" id="user" name="user" value="{{ Auth::user()->person_id }}">
                        {{ csrf_field() }}
                        
                        <div class="box-body">
                            <div class="col-md-8">

                                <div class="form-group" ng-class="{'has-error has-feedback': checkValidate(type, 'cate_id')}">
                                    <label class="control-label">หมวดครุภัณฑ์ :</label>
                                    <select id="cate_id"
                                            name="cate_id"
                                            class="form-control select2" 
                                            style="width: 100%; font-size: 12px;">
                                            
                                        <option value="" selected="selected">-- กรุณาเลือก --</option>

                                        @foreach($cates as $cate)

                                            <option value="{{ $cate->cate_id }}" {{ $cate->cate_id == $type->cate_id ? 'selected' : '' }}>
                                                {{ $cate->cate_no.'-'.$cate->cate_name }}
                                            </option>

                                        @endforeach
                                        
                                    </select>
                                    <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate(type, 'cate_id')"></span>
                                    <span class="help-block" ng-show="checkValidate(type, 'cate_id')">กรุณาเลือกหมวดครุภัณฑ์</span>
                                </div>

                                <div class="form-group" ng-class="{'has-error has-feedback': checkValidate(type, 'type_no')}">
                                    <label class="control-label">รหัสชนิดครุภัณฑ์ :</label>
                                    <input
                                        type="text"
                                        id="type_no"
                                        name="type_no"
                                        ng-model="type.type_no"
                                        class="form-control">
                                    <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate(type, 'type_no')"></span>
                                    <span class="help-block" ng-show="checkValidate(type, 'type_no')">กรุณากรอกรหัสชนิดครุภัณฑ์ก่อน</span>
                                </div>

                                <div class="form-group" ng-class="{'has-error has-feedback': checkValidate(type, 'type_name')}">
                                    <label class="control-label">ชื่อชนิดครุภัณฑ์ :</label>
                                    <input
                                        type="text"
                                        id="type_name"
                                        name="type_name"
                                        ng-model="type.type_name"
                                        class="form-control">
                                    <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate(type, 'type_name')"></span>
                                    <span class="help-block" ng-show="checkValidate(type, 'type_name')">กรุณากรอกชื่อชนิดครุภัณฑ์ก่อน</span>
                                </div>

                                <div class="form-group" ng-class="{'has-error has-feedback': checkValidate(type, 'life_y')}">
                                    <label class="control-label">อายุการใช้งาน (ปี) :</label>
                                    <input
                                        type="text"
                                        id="life_y"
                                        name="life_y"
                                        ng-model="type.life_y"
                                        class="form-control">
                                    <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate(type, 'life_y')"></span>
                                    <span class="help-block" ng-show="checkValidate(type, 'life_y')">กรุณาระบุอายุการใช้งานก่อน</span>
                                </div>

                                <div class="form-group" ng-class="{'has-error has-feedback': checkValidate(type, 'deprec_rate_y')}">
                                    <label class="control-label">อัตรค่าเสื่อม/ปี (ร้อยละ) :</label>
                                    <input
                                        type="text"
                                        id="deprec_rate_y"
                                        name="deprec_rate_y"
                                        ng-model="type.deprec_rate_y"
                                        class="form-control">
                                    <span class="glyphicon glyphicon-remove form-control-feedback" ng-show="checkValidate(type, 'deprec_rate_y')"></span>
                                    <span class="help-block" ng-show="checkValidate(type, 'deprec_rate_y')">กรุณาระบุอัตรค่าเสื่อม/ปีก่อน</span>
                                </div>

                            </div><!-- /.col -->
                        </div><!-- /.box-body -->
                  
                        <div class="box-footer clearfix">
                            <button
                                ng-click="formValidate($event, '/asset-type/validate', type, 'frmEditAssetType', update)"
                                class="btn btn-warning pull-right"
                            >
                                แก้ไข
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
        });
    </script>

@endsection