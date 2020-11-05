app.controller('assetCateCtrl', function($scope, $http, toaster, CONFIG, ModalService) {
/** ################################################################################## */
    $scope.loading = false;
    $scope.cates = [];
    $scope.pager = [];
    
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
        $scope.cates = [];
        $scope.loading = true;

    	$http.get(URL)
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

    $scope.add = function(event, form) {
        event.preventDefault();

        $http.post(CONFIG.baseUrl + '/asset-cate/store', $scope.cate)
        .then(function(res) {
            console.log(res);
            toaster.pop('success', "", 'บันทึกข้อมูลเรียบร้อยแล้ว !!!');
        }, function(err) {
            console.log(err);
            toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
        });

        document.getElementById(form).reset();
    }

    $scope.getAssettype = function(cateId) {
        $http.get(CONFIG.baseUrl + '/asset-cate/get-asset-cate/' +cateId)
        .then(function(res) {
            console.log(res);
            $scope.cate = res.data.cate;
        }, function(err) {
            console.log(err);
        });
    }

    $scope.edit = function(cateId) {
        console.log(cateId);

        window.location.href = CONFIG.baseUrl + '/asset-cate/edit/' + cateId;
    };

    $scope.update = function(event, form, cateId) {
        console.log(cateId);
        event.preventDefault();

        if(confirm("คุณต้องแก้ไขรายการหนี้เลขที่ " + cateId + " ใช่หรือไม่?")) {
            $http.put(CONFIG.baseUrl + '/asset-cate/update/', $scope.cate)
            .then(function(res) {
                console.log(res);
                toaster.pop('success', "", 'แก้ไขข้อมูลเรียบร้อยแล้ว !!!');
            }, function(err) {
                console.log(err);
                toaster.pop('error', "", 'พบข้อผิดพลาด !!!');
            });
        }
    };

    $scope.delete = function(cateId) {
        console.log(cateId);

        if(confirm("คุณต้องลบรายการหนี้เลขที่ " + cateId + " ใช่หรือไม่?")) {
            $http.delete(CONFIG.baseUrl + '/asset-cate/delete/' +cateId)
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