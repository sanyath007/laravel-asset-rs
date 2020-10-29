app.controller('assetCateCtrl', function($scope, $http, toaster, CONFIG, ModalService) {
/** ################################################################################## */
    $scope.loading = false;
    $scope.pager = [];
    $scope.cates = [];
    $scope.cate = {
        cate_id: '',
        cate_no: '',
        cate_name: '',
    };

    $scope.getData = function(event) {
        console.log(event);
        $scope.cates = [];
        $scope.loading = true;
        
        let searchKey = ($("#searchKey").val() == '') ? 0 : $("#searchKey").val();
        $http.get(CONFIG.baseUrl+ '/asset-cate/search/' +searchKey)
        .then(function(res) {
            console.log(res);
            $scope.cates = res.data.cates.data;
            $scope.pager = res.data.cates;

            $scope.loading = false;
        }, function(err) {
            console.log(err);
            $scope.loading = false;
        });
    }

    $scope.getDataWithURL = function(URL) {
        console.log(URL);
        $scope.debttypes = [];
        $scope.loading = true;

    	$http.get(URL)
    	.then(function(res) {
    		console.log(res);
            $scope.debttypes = res.data.debttypes.data;
            $scope.pager = res.data.debttypes;

            $scope.loading = false;
    	}, function(err) {
    		console.log(err);
            $scope.loading = false;
    	});
    }

    $scope.add = function(event, form) {
        console.log(event);
        event.preventDefault();

        if (form.$invalid) {
            toaster.pop('warning', "", 'กรุณาข้อมูลให้ครบก่อน !!!');
            return;
        } else {
            $http.post(CONFIG.baseUrl + '/asset-cate/store', $scope.debttype)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'บันทึกข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });            
        }

        document.getElementById('frmNewDebttype').reset();
    }

    $scope.getAssettype = function(debttypeId) {
        $http.get(CONFIG.baseUrl + '/asset-cate/get-asset-type/' +debttypeId)
        .then(function(res) {
            console.log(res);
            $scope.debttype = res.data.debttype;
        }, function(err) {
            console.log(err);
        });
    }

    $scope.edit = function(debttypeId) {
        console.log(debttypeId);

        window.location.href = CONFIG.baseUrl + '/asset-cate/edit/' + debttypeId;
    };

    $scope.update = function(event, form, debttypeId) {
        console.log(debttypeId);
        event.preventDefault();

        if(confirm("คุณต้องแก้ไขรายการหนี้เลขที่ " + debttypeId + " ใช่หรือไม่?")) {
            $http.put(CONFIG.baseUrl + '/asset-cate/update/', $scope.debttype)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'แก้ไขข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });
        }
    };

    $scope.delete = function(debttypeId) {
        console.log(debttypeId);

        if(confirm("คุณต้องลบรายการหนี้เลขที่ " + debttypeId + " ใช่หรือไม่?")) {
            $http.delete(CONFIG.baseUrl + '/asset-cate/delete/' +debttypeId)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'ลบข้อมูลเรียบร้อยแล้ว !!!');
                $scope.getData();
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });
        }
    };
});