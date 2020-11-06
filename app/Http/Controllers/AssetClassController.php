<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AssetClass;

class AssetClassController extends Controller
{
    public function formValidate (Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'class_no' => 'required',
            'class_name' => 'required'
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
    	return view('asset-classes.list');
    }

    public function search($searchKey)
    {
        if($searchKey == '0') {
            $cates = AssetClass::paginate(20);
        } else {
            $cates = AssetClass::where('class_name', 'like', '%'.$searchKey.'%')->paginate(20);
        }

        return [
            'cates' => $cates,
        ];
    }

    private function generateAutoId()
    {
        $cate = \DB::table('asset_cates')
                        ->select('class_no')
                        ->orderBy('class_no', 'DESC')
                        ->first();

        $tmpLastNo =  ((int)($cate->class_no)) + 1;
        $lastNo = sprintf("%'.05d", $tmpLastNo);

        return $lastId;
    }

    public function add()
    {
    	return view('asset-classes.add', [
            'cates' => AssetClass::all(),
    	]);
    }

    public function store(Request $req)
    {
        $cate = new AssetClass();
        // $cate->class_id = $this->generateAutoId();
        $cate->class_no = $req['class_no'];
        $cate->class_name = $req['class_name'];

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

    public function getById($classId)
    {
        return [
            'cate' => AssetClass::find($classId),
        ];
    }

    public function edit($classId)
    {
        return view('asset-classes.edit', [
            'type' => AssetClass::find($classId),
            'cates' => \DB::table('asset_categories')->select('*')->get(),
        ]);
    }

    public function update(Request $req)
    {
        $type = AssetClass::find($req['class_id']);

        $type->class_id = $req['class_id'];
        $type->class_name = $req['class_name'];

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

    public function delete($classId)
    {
        $type = AssetClass::find($classId);

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
