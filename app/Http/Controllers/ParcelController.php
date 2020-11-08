<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\Parcel;
use App\Models\AssetCategory;
use App\Models\AssetType;
use App\Models\AssetUnit;
use App\Models\BudgetType;
use App\Models\DeprecType;
use App\Models\PurchasedMethod;
use App\Models\DocumentType;
use App\Models\Supplier;
use App\Models\Department;


class ParcelController extends Controller
{   
    protected $status = [
        '1' => 'รอเบิก',
        '2' => 'ใช้งานอยู่',
        '3' => 'ถูกยืม',
        '4' => 'จำหน่าย',
    ];
    
    protected $parcelType = [
        '1' => 'วัสดุสิ้นเปลื้อง',
        '2' => 'วัสดุคงทน',
        '3' => 'ครุภัณฑ์',
        '4' => 'บริการ',
        '5' => 'อาคาร/สิ่งปลูกสร้าง',
        '6' => 'ที่ดิน',
    ];

    public function formValidate (Request $request)
    {
        $validator = \Validator::make($request->all(), [
            'asset_no' => 'required',
            'asset_name' => 'required',
            'asset_type' => 'required',
            'amount' => 'required',
            'unit' => 'required',
            'unit_price' => 'required',
            'purchased_method' => 'required',
            'budget_type' => 'required',
            'year' => 'required',
            'supplier' => 'required',
            'doc_type' => 'required',
            'doc_no' => 'required',
            'doc_date' => 'required',
            'date_in' => 'required',
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
    	return view('parcels.list', [
            "suppliers"     => Supplier::all(),
            "cates"         => AssetCategory::orderBy('cate_no')->get(),
            "types"         => AssetType::all(),
            "parcel_types"  => $this->parcelType
    	]);
    }

    public function search($parcelType, $searchKey)
    {
        $conditions = [];
        if($parcelType != 0) array_push($conditions, ['parcel_type', '=', $parcelType]);
        if($searchKey !== '0') array_push($conditions, ['parcel_name', 'like', '%'.$searchKey.'%']);

        if($conditions == '0') {
            $parcels = Parcel::with('assetType')
                        ->with('deprecType')->toSql();
                        // ->paginate(20);
        } else {
            $parcels = Parcel::where($conditions)
                        ->with('assetType')
                        ->with('deprecType')
                        ->paginate(20);
        }
        
        return [
            'parcels' => $parcels,
            "parcel_types"  => $this->parcelType
        ];
    }

    public function getAjexAll($cateId)
    {
        $types = AssetType::where('cate_id', '=', $cateId)->get();

        return [
            'types' => $types,
        ];
    }

    private function generateAutoId()
    {
        $debt = \DB::table('nrhosp_acc_debt')
                        ->select('debt_id')
                        ->orderBy('debt_id', 'DESC')
                        ->first();

        $startId = 'DB'.substr((date('Y') + 543), 2);
        $tmpLastId =  ((int)(substr($debt->debt_id, 4))) + 1;
        $lastId = $startId.sprintf("%'.07d", $tmpLastId);

        return $lastId;
    }

    public function add()
    {
    	return view('parcels.add', [
            "parcels"     => Parcel::all(),
            "deprecTypes"     => DeprecType::all(),
            "units"     => AssetUnit::all(),
            "budgets"   => BudgetType::all(),
            "docs"   => DocumentType::all(),
            "methods"     => PurchasedMethod::all(),
            "suppliers" => Supplier::all(),
            "departs" => Department::all(),
            "statuses"  => $this->status
    	]);
    }

    public function store(Request $req)
    {
        $asset = new Asset();
        // $asset->asset_id = $this->generateAutoId();
        $asset->asset_no = $req['asset_no'];
        $asset->asset_name = $req['asset_name'];
        $asset->description = $req['description'];
        $asset->asset_type = $req['asset_type'];
        $asset->amount = $req['amount'];
        $asset->unit = $req['unit'];
        $asset->unit_price = $req['unit_price'];
        $asset->purchased_method = $req['purchased_method'];
        $asset->reg_no = $req['reg_no'];
        $asset->budget_type = $req['budget_type'];
        $asset->year = $req['year'];
        $asset->supplier = $req['supplier'];
        $asset->doc_type = $req['doc_type'];
        $asset->doc_no = $req['doc_no'];
        $asset->doc_date = $req['doc_date'];
        $asset->date_in = $req['date_in'];
        $asset->remark = $req['remark'];
        $asset->status = '1';

        /** Upload image */
        $asset->image = '';

        if($asset->save()) {
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

    public function getById($parcelId)
    {
        return [
            'parcel' => Parcel::with('deprecType')->get()->find($parcelId),
        ];
    }

    public function edit($assetId)
    {
        return view('parcels.edit', [
            "asset"         => Asset::find($assetId),
            "parcels"     => Parcel::all(),
            "deprecTypes"   => DeprecType::all(),
            "units"         => AssetUnit::all(),
            "budgets"       => BudgetType::all(),
            "docs"          => DocumentType::all(),
            "methods"       => PurchasedMethod::all(),
            "suppliers"     => Supplier::all(),
            "departs"       => Department::all(),
            "statuses"      => $this->status
        ]);
    }

    public function update(Request $req)
    {
        $asset = Asset::find($req['asset_id']);
        $asset->asset_no = $req['asset_no'];
        $asset->asset_name = $req['asset_name'];
        $asset->description = $req['description'];
        $asset->asset_type = $req['asset_type'];
        $asset->amount = $req['amount'];
        $asset->unit = $req['unit'];
        $asset->unit_price = $req['unit_price'];
        $asset->purchased_method = $req['method'];
        $asset->reg_no = $req['reg_no'];
        $asset->budget_type = $req['budget_type'];
        $asset->year = $req['year'];
        $asset->supplier = $req['supplier'];
        $asset->doc_type = $req['doc_type'];
        $asset->doc_no = $req['doc_no'];
        $asset->doc_date = $req['doc_date'];
        $asset->date_in = $req['date_in'];
        $asset->remark = $req['remark'];
        $asset->status = $req['status'];

        /** Upload image */
        $asset->image = '';

        if($asset->save()) {
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

    public function delete($assetId)
    {
        $asset = Asset::find($assetId);

        if($asset->delete()) {
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

    public function discharge()
    {
        return view('parcels.discharge-list', [
            "suppliers" => Supplier::all(),
            "cates"     => AssetCategory::all(),
            "types"     => AssetType::all(),
            "statuses"    => $this->status
        ]);
    }

    public function doDischarge(Request $req)
    {
        if(Asset::where('asset_id', '=', $req['asset_id'])
                ->update(['status' => '4']) <> 0) {
            return [
                'status' => 'success',
                'message' => 'Updated id ' .$req['asset_id']. 'is successed.',
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Updated id ' .$req['asset_id']. 'is failed.',
            ];
        }
    }
}
