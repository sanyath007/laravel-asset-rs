app.controller('assetCtrl', function(CONFIG, $scope, $http, toaster, ModalService, StringFormatService, ReportService, PaginateService) {
/** ################################################################################## */
    $scope.loading = false;
    $scope.cboAssetCate = "";
    $scope.cboAssetType = "";
    $scope.cboAssetStatus = "";
    $scope.searchKeyword = "";

    $scope.types = [];
    $scope.assets = [];

    $scope.asset = {
        asset_id: '',
        asset_no: '',
        asset_name: '',
        description: '',
        asset_type: '',
        amount: '',
        unit: '',
        unit_price: '',
        method: '',
        image: '',
        reg_no: '',
        budget_type: '',
        year: '',
        supplier: '',
        doc_type: '',
        doc_no: '',
        doc_date: '',
        date_in: '',
        remark: '',
        status: '',
    };

    $scope.barOptions = {};

    $scope.clearAssetObj = function() {
        $scope.asset = {
            asset_id: '',
            asset_no: '',
            asset_name: '',
            description: '',
            asset_type: '',
            amount: '',
            unit: '',
            unit_price: '',
            purchased_method: '',
            image: '',
            reg_no: '',
            budget_type: '',
            year: '',
            supplier: '',
            doc_no: '',
            doc_date: '',
            doc_type: '',
            date_in: '',
            remark: '',
            status: '',
        };
    };

    $scope.getData = function(event) {
        console.log(event);
        $scope.assets = [];
        $scope.loading = true;

        let assetCate = $("#assetCate").val() === '' ? 0 : $("#assetCate").val();
        let assetType = $("#assetType").val() === '' ? 0 : $("#assetType").val();
        let assetStatus = $("#assetStatus").val() === '' ? 0 : $("#assetStatus").val();
        let searchKey = $("#searchKey").val() === '' ? 0 : $("#searchKey").val();

        $http.get(CONFIG.baseUrl+ '/asset/search/' +assetCate+ '/' +assetType+ '/' +assetStatus+ '/' +searchKey)
        .then(function(res) {            
            $scope.assets = res.data.assets.data;
            $scope.pager = res.data.assets;

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.getAssetType = function () {
        console.log($scope.asset.asset_cate);
        $http.get(CONFIG.baseUrl+ '/asset-type/get-ajex-all/' +$scope.asset.asset_cate)
        .then(function(res) {
            $scope.types = res.data.types;

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.getAssetChart = function (creditorId) {
        ReportService.getSeriesData('/report/debt-chart/', creditorId)
        .then(function(res) {
            console.log(res);

            var debtSeries = [];
            var paidSeries = [];
            var setzeroSeries = [];

            angular.forEach(res.data, function(value, key) {
                let debt = (value.debt) ? parseFloat(value.debt.toFixed(2)) : 0;
                let paid = (value.paid) ? parseFloat(value.paid.toFixed(2)) : 0;
                let setzero = (value.setzero) ? parseFloat(value.setzero.toFixed(2)) : 0;
                
                debtSeries.push(debt);
                paidSeries.push(paid);
                setzeroSeries.push(setzero);
            });

            var categories = ['ยอดหนี้']
            $scope.barOptions = ReportService.initBarChart("barContainer", "", categories, 'จำนวน');
            $scope.barOptions.series.push({
                name: 'หนี้คงเหลือ',
                data: debtSeries
            }, {
                name: 'ตัดจ่ายแล้ว',
                data: paidSeries
            }, {
                name: 'ลดหนี้ศูนย์',
                data: setzeroSeries
            });

            var chart = new Highcharts.Chart($scope.barOptions);
        }, function(err) {
            console.log(err);
        });
    };

    $scope.getAssetData = function(URL) {
        $scope.assets = [];
        $scope.assetPager = [];
        $scope.assetPages = [];

        $scope.loading = true;
        var assetType = ($("#assetType").val() != '') ? $("#assetType").val() : 0;
        var assetType = ($("#assetType").val() != '') ? $("#assetType").val() : 0;
        var showAll = ($("#showall:checked").val() == 'on') ? 1 : 0;

        $http.get(CONFIG.baseUrl +URL+ '/' +debtType+ '/' +sDate+ '/' +eDate+ '/' +showAll)
        .then(function(res) {
            console.log(res);
            $scope.assets = res.data.assets.data;
            $scope.assetPager = res.data.assets;
            $scope.assetPages = PaginateService.createPagerNo($scope.assetPager);

            $scope.loading = false;
    	}, function(err) {
    		console.log(err);
            $scope.loading = false;
    	});
    }

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
    }

    $scope.calculateVat = function(amount, vatRate) {
        $scope.debt.debt_vat = ((amount * vatRate) / 100).toFixed(2);
        $scope.debt.debt_total = (parseFloat(amount) + parseFloat($scope.debt.debt_vat)).toFixed(2);
    }

    $scope.store = function(event, form) {
        console.log(event);
        event.preventDefault();

        if (form.$invalid) {
            console.log(form.$error);
            toaster.pop('warning', "", 'กรุณาข้อมูลให้ครบก่อน !!!');
            return;
        } else {
            /** Convert thai date to db date. */
            $scope.asset.date_in = StringFormatService.convToDbDate($scope.asset.date_in);
            $scope.asset.doc_date = StringFormatService.convToDbDate($scope.asset.doc_date);
            /** Get user id */
            $scope.asset.created_by = $("#user").val();
            $scope.asset.updated_by = $("#user").val();
            console.log($scope.asset);

            $http.post(CONFIG.baseUrl + '/asset/store', $scope.asset)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'บันทึกข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });            
        }

        /** Clear control value and model data */
        document.getElementById('frmNewAsset').reset();
        $scope.clearAssetObj();
    }

    $scope.getAsset = function(assetId) {
        $http.get(CONFIG.baseUrl + '/asset/get-asset/' +assetId)
        .then(function(res) {
            console.log(res);
            $scope.asset = res.data.asset;

            /** Convert db date to thai date. */
            $scope.asset.date_in = StringFormatService.convFromDbDate($scope.asset.date_in);
            $scope.asset.doc_date = StringFormatService.convFromDbDate($scope.asset.doc_date);
        }, function(err) {
            console.log(err);
        });
    }

    $scope.edit = function(assetId) {
        console.log(assetId);

        /** Show edit form modal dialog */
        // $('#dlgEditForm').modal('show');

        if(creditor === '') {
            console.log("You doesn't select creditor !!!");
            toaster.pop('warning', "", "คุณยังไม่ได้เลือกเจ้าหนี้ !!!");
        } else {
            window.location.href = CONFIG.BASE_URL + '/asset/edit/' + assetId;
        }
    };

    $scope.update = function(event, form, assetId) {
        console.log(debtId);
        event.preventDefault();

        if (form.$invalid) {
            toaster.pop('warning', "", 'กรุณาข้อมูลให้ครบก่อน !!!');
            return;
        } else {
            /** Convert thai date to db date. */
            $scope.asset.date_in = StringFormatService.convToDbDate($scope.asset.date_in);
            $scope.asset.doc_date = StringFormatService.convToDbDate($scope.asset.doc_date);
            /** Get user id */
            $scope.asset.created_by = $("#user").val();
            $scope.asset.updated_by = $("#user").val();
            console.log($scope.asset);

            if(confirm("คุณต้องแก้ไขรายการหนี้เลขที่ " + assetId + " ใช่หรือไม่?")) {
                $http.put(CONFIG.BASE_URL + '/asset/update/', $scope.asset)
                .then(function(res) {
                    console.log(res);
                }, function(err) {
                    console.log(err);
                });
            }

            /** Redirect to debt list */
            window.location.href = CONFIG.BASE_URL + '/debt/list';
        }
    };

    $scope.delete = function(debtId) {
        console.log(debtId);

        if(confirm("คุณต้องลบรายการหนี้เลขที่ " + debtId + " ใช่หรือไม่?")) {
            $http.delete(CONFIG.BASE_URL + '/debt/delete/' +debtId)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'ลบข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });
        }

        /** Get debt list and re-render chart */
        $scope.getDebtData('/debt/rpt'); 
        $scope.getDebtChart($scope.cboDebtType);
    };

    $scope.discharge = function(assetId) {
        console.log(assetId);

        if(confirm("คุณต้องลดหนี้เป็นศูนย์รายการหนี้เลขที่ " + assetId + " ใช่หรือไม่?")) {
            $http.post(CONFIG.BASE_URL + '/asset/discharge', { asset_id: assetId })
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