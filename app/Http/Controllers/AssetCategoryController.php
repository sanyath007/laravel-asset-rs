<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AssetCategory;

class AssetCategoryController extends Controller
{
    public function formValidate (Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'cate_no' => 'required',
            'cate_name' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'success' => 0,
                'errors' => $validator->getMessageBag()->toArray(),
            ];
        } else {
            return [
                'success' => 1,
                'errors' => $validator->getMessageBag()->toArray(),
            ];
        }
    }

    public function list()
    {
    	return view('asset-cates.list');
    }

    public function search($searchKey)
    {
        if($searchKey == '0') {
            $cates = AssetCategory::orderBy('cate_no')->paginate(20);
        } else {
            $cates = AssetCategory::where('cate_name', 'like', '%'.$searchKey.'%')->orderBy('cate_no')->paginate(20);
        }

        return [
            'cates' => $cates,
        ];
    }

    private function generateAutoId()
    {
        $cate = \DB::table('asset_cates')
                        ->select('cate_no')
                        ->orderBy('cate_no', 'DESC')
                        ->first();

        $tmpLastNo =  ((int)($cate->cate_no)) + 1;
        $lastNo = sprintf("%'.05d", $tmpLastNo);

        return $lastId;
    }

    public function add()
    {
    	return view('asset-cates.add', [
            'cates' => AssetCategory::all(),
    	]);
    }

    public function store(Request $req)
    {
        $cate = new AssetCategory();
        // $cate->cate_id = $this->generateAutoId();
        $cate->cate_no = $req['cate_no'];
        $cate->cate_name = $req['cate_name'];

        if($cate->save()) {
            return [
                "status" => "success",
                "message" => "Insert success.",
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Insert failed.",
            ];
        }
    }

    public function getById($cateId)
    {
        return [
            'cate' => AssetCategory::find($cateId),
        ];
    }

    public function edit($cateId)
    {
        return view('asset-cates.edit', [
            'type' => AssetCategory::find($cateId),
            'cates' => \DB::table('asset_categories')->select('*')->get(),
        ]);
    }

    public function update(Request $req)
    {
        $type = AssetCategory::find($req['cate_id']);

        $type->cate_id = $req['cate_id'];
        $type->cate_name = $req['cate_name'];

        if($type->save()) {
            return [
                "status" => "success",
                "message" => "Update success.",
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Update failed.",
            ];
        }
    }

    public function delete($cateId)
    {
        $type = AssetCategory::find($cateId);

        if($type->delete()) {
            return [
                "status" => "success",
                "message" => "Delete success.",
            ];
        } else {
            return [
                "status" => "error",
                "message" => "Delete failed.",
            ];
        }
    }
}
