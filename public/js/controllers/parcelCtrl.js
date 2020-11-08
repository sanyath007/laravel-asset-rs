app.controller('parcelCtrl', function(CONFIG, $scope, $http, toaster, ModalService, StringFormatService, ReportService, PaginateService) {
/** ################################################################################## */
    $scope.loading = false;
    $scope.cboParcelType = "";
    $scope.searchKeyword = "";

    $scope.types = [];
    $scope.parcels = [];
    $scope.parcel_types = [];

    $scope.parcel = {
        parcel_id: '',
        parcel_no: '',
        parcel_name: '',
        description: '',
        asset_type: '',
        unit: '',
        unit_price: '',
        supplier: '',
        deprec_type: '',
        first_y_month: '',
        remark: '',
        status: '',
    };

    $scope.barOptions = {};

    $scope.clearAssetObj = function() {
        $scope.asset = {
            parcel_id: '',
            parcel_no: '',
            parcel_name: '',
            description: '',
            asset_type: '',
            unit: '',
            unit_price: '',
            supplier: '',
            deprec_type: '',
            first_y_month: '',
            remark: '',
            status: '',
        };
    };

    $scope.getData = function(event) {
        $scope.parcels = [];
        $scope.loading = true;

        let parcelType = $scope.cboParcelType === '' ? 0 : $scope.cboParcelType; 
        let searchKey = $scope.searchKeyword === '' ? 0 : $scope.searchKeyword;

        console.log(CONFIG.baseUrl+ '/parcel/search/' +parcelType+ '/' +searchKey);
        $http.get(CONFIG.baseUrl+ '/parcel/search/' +parcelType+ '/' +searchKey)
        .then(function(res) {      
            console.log(res);
            $scope.parcel_types = res.data.parcel_types;
            $scope.parcels = res.data.parcels.data;
            $scope.pager = res.data.parcels;

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.getAssetType = function (cateId) {
        $scope.loading = true;

        $http.get(CONFIG.baseUrl+ '/asset-type/get-ajax-all/' +cateId)
        .then(function(res) {
            console.log(res);
            $scope.types = res.data.types;

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    };

    $scope.getParcel = function(parcelId) {
        $http.get(CONFIG.baseUrl + '/parcel/get-ajax-byid/' +parcelId)
        .then(function(res) {
            $scope.parcel = res.data.parcel;
        }, function(err) {
            console.log(err);
        });
    };

    $scope.getDebtWithURL = function(URL) {
        console.log(URL);
        $scope.debts = [];
        $scope.debtPager = [];
        $scope.debtPages = [];

        $scope.loading = true;

        $http.get(URL)
        .then(function(res) {
            console.log(res);
            $scope.debts = res.data.debts.data;
            $scope.debtPager = res.data.debts;
            $scope.debtPages = PaginateService.createPagerNo($scope.debtPager);

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    };

    $scope.store = function(event, form) {
        event.preventDefault();
        /** Convert thai date to db date. */
        $scope.asset.date_in = StringFormatService.convToDbDate($scope.asset.date_in);
        $scope.asset.doc_date = StringFormatService.convToDbDate($scope.asset.doc_date);
        /** Get user id */
        // $scope.asset.created_by = $("#user").val();
        // $scope.asset.updated_by = $("#user").val();
        console.log($scope.asset);

        $http.post(CONFIG.baseUrl + '/asset/store', $scope.asset)
        .then(function(res) {
            console.log(res);
            toaster.pop('success', "", 'บันทึกข้อมูลเรียบร้อยแล้ว !!!');
        }, function(err) {
            console.log(err);
            toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
        });

        /** Clear control value and model data */
        document.getElementById(form).reset();
        $scope.clearAssetObj();
    };

    $scope.edit = function(assetId) {
        console.log(assetId);

        /** Show edit form modal dialog */
        // $('#dlgEditForm').modal('show');BASE_URL
        window.location.href = CONFIG.baseUrl + '/asset/edit/' + assetId;
    };

    $scope.update = function(event, form) {
        event.preventDefault();

        /** Convert thai date to db date. */
        $scope.asset.date_in = StringFormatService.convToDbDate($scope.asset.date_in);
        $scope.asset.doc_date = StringFormatService.convToDbDate($scope.asset.doc_date);
        /** Get user id */
        // $scope.asset.created_by = $("#user").val();
        // $scope.asset.updated_by = $("#user").val();
        console.log($scope.asset);

        if(confirm("คุณต้องแก้ไขรายการหนี้เลขที่ " + assetId + " ใช่หรือไม่?")) {
            $http.put(CONFIG.baseUrl + '/asset/update/', $scope.asset)
            .then(function(res) {
                console.log(res);
            }, function(err) {
                console.log(err);
            });
        }

        /** Redirect to debt list */
        window.location.href = CONFIG.baseUrl + '/asset/list';
    };

    $scope.delete = function(assettId) {
        console.log(assettId);

        if(confirm("คุณต้องลบรายการหนี้เลขที่ " + assettId + " ใช่หรือไม่?")) {
            $http.delete(CONFIG.baseUrl + '/asset/delete/' +assettId)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'ลบข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });
        }

        /** Get debt list and re-render chart */
        // $scope.getDebtData('/asset/rpt');
        // $scope.getDebtChart($scope.cboDebtType);
    };

    $scope.discharge = function(assetId) {
        console.log(assetId);

        if(confirm("คุณต้องลดหนี้เป็นศูนย์รายการหนี้เลขที่ " + assetId + " ใช่หรือไม่?")) {
            $http.post(CONFIG.baseUrl + '/asset/discharge', { asset_id: assetId })
            .then(function(res) {
                console.log(res);
                if(res.data.status == 'success') {
                    toaster.pop('success', "ระบบทำการงลดหนี้เป็นศูนย์สำเร็จแล้ว", "");
                } else { 
                    toaster.pop('error', "พบข้อผิดพลาดในระหว่างการดำเนินการ !!!", "");
                }
            }, function(err) {
                console.log(err);

                toaster.pop('error', "พบข้อผิดพลาดในระหว่างการดำเนินการ !!!", "");
            });
        }
    };
});