<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\AssetType;

class AssetTypeController extends Controller
{
    public function list()
    {
    	return view('asset-types.list');
    }

    public function search($searchKey)
    {
        if($searchKey == '0') {
            $types = AssetType::with('cates')->paginate(20);
        } else {
            $types = AssetType::where('type_name', 'like', '%'.$searchKey.'%')
                        ->with('cates')
                        ->paginate(20);
        }

        return [
            'types' => $types,
        ];
    }

    private function generateAutoId()
    {
        $type = \DB::table('asset_types')
                        ->select('type_no')
                        ->orderBy('type_no', 'DESC')
                        ->first();

        $tmpLastNo =  ((int)($type->type_no)) + 1;
        $lastNo = sprintf("%'.05d", $tmpLastNo);

        return $lastId;
    }

    public function add()
    {
    	return view('asset-types.add', [
            'cates' => \DB::table('asset_categories')->select('*')->get(),
    	]);
    }

    public function store(Request $req)
    {
        $lastId = $this->generateAutoId();

        $type = new AssetType();
        $type->type_id = $lastId;
        $type->type_name = $req['type_name'];
        $type->cate_id = $req['cate_id'];
        // $type->cate_name = $req['cate_name'];
        $type->type_status = '1';

        if($type->save()) {
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

    public function getById($typeId)
    {
        return [
            'type' => AssetType::find($typeId),
        ];
    }

    public function edit($typeId)
    {
        return view('asset-types.edit', [
            'type' => AssetType::find($typeId),
            'cates' => \DB::table('asset_categories')->select('*')->get(),
        ]);
    }

    public function update(Request $req)
    {
        $type = AssetType::find($req['type_id']);

        $type->type_name = $req['type_name'];
        $type->cate_id = $req['cate_id'];
        // $type->cate_name = $req['cate_name'];

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

    public function delete($typeId)
    {
        $type = AssetType::find($typeId);

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
