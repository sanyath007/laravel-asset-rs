<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AssetGroup;

class AssetGroupController extends Controller
{
    public function formValidate (Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'group_no' => 'required',
            'group_name' => 'required'
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
    	return view('asset-groups.list');
    }

    public function search($searchKey)
    {
        if($searchKey == '0') {
            $cates = AssetGroup::paginate(20);
        } else {
            $cates = AssetGroup::where('group_name', 'like', '%'.$searchKey.'%')->paginate(20);
        }

        return [
            'cates' => $cates,
        ];
    }

    private function generateAutoId()
    {
        $cate = \DB::table('asset_cates')
                        ->select('group_no')
                        ->orderBy('group_no', 'DESC')
                        ->first();

        $tmpLastNo =  ((int)($cate->group_no)) + 1;
        $lastNo = sprintf("%'.05d", $tmpLastNo);

        return $lastId;
    }

    public function add()
    {
    	return view('asset-groups.add', [
            'cates' => AssetGroup::all(),
    	]);
    }

    public function store(Request $req)
    {
        $cate = new AssetGroup();
        // $cate->group_id = $this->generateAutoId();
        $cate->group_no = $req['group_no'];
        $cate->group_name = $req['group_name'];

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

    public function getById($groupId)
    {
        return [
            'cate' => AssetGroup::find($groupId),
        ];
    }

    public function edit($groupId)
    {
        return view('asset-groups.edit', [
            'type' => AssetGroup::find($groupId)
        ]);
    }

    public function update(Request $req)
    {
        $type = AssetGroup::find($req['group_id']);

        $type->group_id = $req['group_id'];
        $type->group_name = $req['group_name'];

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

    public function delete($groupId)
    {
        $type = AssetGroup::find($groupId);

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
