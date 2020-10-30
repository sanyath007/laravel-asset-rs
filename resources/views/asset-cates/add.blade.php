@extends('layouts.main')

@section('content')

    <!-- Content Header (Page header) -->
    <section class="content-header">
        <h1>
            เพิ่มหมวดครุภัณฑ์
            <!-- <small>preview of simple tables</small> -->
        </h1>

        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="#">หน้าหลัก</a></li>
            <li class="breadcrumb-item active">เพิ่มหมวดครุภัณฑ์</li>
        </ol>
    </section>

    <!-- Main content -->
    <section class="content" ng-controller="assetCateCtrl">

        <div class="row">
            <div class="col-md-12">

                <div class="box box-primary">
                    <div class="box-header">
                        <h3 class="box-title">ฟอร์มเพิ่มหมวดครุภัณฑ์</h3>
                    </div>

                    <form id="frmNewAssetCate" name="frmNewAssetCate" method="post" action="{{ url('/debttype/store') }}" role="form">
                        <input type="hidden" id="user" name="user" value="{{ Auth::user()->person_id }}">
                        {{ csrf_field() }}
                        
                        <div class="box-body">
                            <div class="col-md-8">
                                <div class="form-group" ng-class="{ 'has-error' : frmNewAssetCate.cate_no.$invalid}">
                                    <label class="control-label">รหัสหมวดครุภัณฑ์ :</label>
                                    <input
                                        type="text"
                                        id="cate_no"
                                        name="cate_no"
                                        ng-model="cate.cate_no"
                                        class="form-control" required>
                                    <div class="help-block" ng-show="frmNewAssetCate.cate_no.$error.required">
                                        กรุณากรอกรหัสหมวดครุภัณฑ์ก่อน
                                    </div>
                                </div> 

                                <div class="form-group" ng-class="{ 'has-error' : frmNewAssetCate.cate_name.$invalid}">
                                    <label class="control-label">ชื่อหมวดครุภัณฑ์ :</label>
                                    <input
                                        type="text"
                                        id="cate_name"
                                        name="cate_name"
                                        ng-model="cate.cate_name"
                                        class="form-control" required>
                                    <div class="help-block" ng-show="frmNewAssetCate.cate_name.$error.required">
                                        กรุณากรอกชื่อหมวดครุภัณฑ์ก่อน
                                    </div>
                                </div> 
                            </div>
                        </div><!-- /.box-body -->
                  
                        <div class="box-footer clearfix">
                            <button ng-click="add($event, frmNewAssetCate)" class="btn btn-success pull-right">
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
        });
    </script>

@endsection