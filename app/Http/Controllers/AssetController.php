<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetType;
use App\Models\AssetUnit;
use App\Models\BudgetType;
use App\Models\PurchasedMethod;
use App\Models\DocumentType;
use App\Models\Supplier;
use App\Models\Department;


class AssetController extends Controller
{   
    protected $status = [
        '1' => 'รอเบิก',
        '2' => 'ใช้งานอยู่',
        '3' => 'ถูกยืม',
        '4' => 'จำหน่าย',
    ];

    public function list()
    {
    	return view('assets.list', [
            "suppliers" => Supplier::all(),
            "cates"     => AssetCategory::all(),
            "types"     => AssetType::all(),
            "statuses"    => $this->status
    	]);
    }

    public function search($cate, $type, $status, $searchKey)
    {
        $conditions = [];
        if($type != 0) array_push($conditions, ['asset_type', '=', $type]);
        if($status != 0) array_push($conditions, ['status', '=', $status]);
        if($searchKey != 0) array_push($conditions, ['asset_name', 'like', '%'.$searchKey.'%']);

        if($conditions == '0') {
            $assets = Asset::with('assetType')
                        ->with('supplier')
                        ->with('budgetType')
                        ->with('docType')
                        ->with('purchasedMethod')
                        ->paginate(20);
        } else {
            $assets = Asset::where($conditions)
                        ->with('assetType')
                        ->with('supplier')
                        ->with('budgetType')
                        ->with('docType')
                        ->with('purchasedMethod')
                        ->paginate(20);
        }

        return [
            'assets' => $assets,
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
    	return view('assets.add', [
            "cates"     => AssetCategory::all(),
            "types"     => AssetType::all(),
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

    public function getById($debtId)
    {
        return [
            'debt' => Debt::find($debtId),
        ];
    }

    public function edit($creditor, $debtId)
    {
        return view('assets.edit', [
            "creditor" => Creditor::where('supplier_id', '=', $creditor)->first(),
            'debt' => Debt::find($debtId),
            "debttypes" => DebtType::all(),
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
        return view('assets.discharge-list', [
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
