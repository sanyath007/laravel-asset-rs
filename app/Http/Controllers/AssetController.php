<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\AssetType;
use App\Models\Supplier;
use App\Models\PurchasedMethod;


class AssetController extends Controller
{
    public function list()
    {
        $status = [
            '1' => 'รอเบิก',
            '2' => 'ใช้งานอยู่',
            '3' => 'ถูกยืม',
            '4' => 'จำหน่าย',
        ];

    	return view('assets.list', [
            "suppliers" => Supplier::all(),
            "cates"     => AssetCategory::all(),
            "types"     => AssetType::all(),
            "statuses"    => $status
    	]);
    }

    public function search($cate, $type, $status, $searchKey)
    {
        if($searchKey == '0') {
            $assets = Asset::with('assetType')
                        ->with('supplier')
                        ->with('budgetType')
                        ->with('docType')
                        ->with('purchasedMethod')
                        ->paginate(20);
        } else {
            $assets = Asset::where('asset_name', 'like', '%'.$searchKey.'%')
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

    public function add($creditor)
    {
    	return view('assets.add', [
    		"creditor" => Creditor::where('supplier_id', '=', $creditor)->first(),
            "debttypes" => DebtType::all(),
    	]);
    }

    public function store(Request $req)
    {
        /** 0=รอดำเนินการ,1=ขออนุมัติ,2=ตัดจ่าย,3=ยกเลิก,4=ลดหนี้ศุนย์ */
        $debt = new Debt();
        $debt->debt_id = $this->generateAutoId();
        $debt->debt_date = $req['debt_date'];
        $debt->debt_doc_recno = $req['debt_doc_recno'];
        $debt->debt_doc_recdate = $req['debt_doc_recdate'];
        $debt->deliver_no = $req['deliver_no'];
        $debt->deliver_date = $req['deliver_date'];
        $debt->debt_doc_no = $req['debt_doc_no'];
        $debt->debt_doc_date = $req['debt_doc_date'];
        $debt->debt_type_id = $req['debt_type_id'];
        $debt->debt_type_detail = $req['debt_type_detail'];
        $debt->debt_month = $req['debt_month'];
        $debt->debt_year = $req['debt_year'];
        $debt->supplier_id = $req['supplier_id'];
        $debt->supplier_name = $req['supplier_name'];
        $debt->doc_receive = $req['doc_receive'];
        $debt->debt_amount = $req['debt_amount'];
        $debt->debt_vatrate = $req['debt_vatrate'];
        $debt->debt_vat = $req['debt_vat'];
        $debt->debt_total = $req['debt_total'];
        $debt->debt_remark = $req['debt_remark'];
        
        $debt->debt_creby = $req['debt_creby'];
        $debt->debt_credate = date("Y-m-d H:i:s");
        $debt->debt_userid = $req['debt_userid'];
        $debt->debt_chgdate = date("Y-m-d H:i:s");
        $debt->debt_status = '0';

        if($debt->save()) {
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
        /** 0=รอดำเนินการ,1=ขออนุมัติ,2=ตัดจ่าย,3=ยกเลิก,4=ลดหนี้ศุนย์ */
        $debt = Debt::find($req['debt_id']);
        $debt->debt_date = $req['debt_date'];
        $debt->debt_doc_recno = $req['debt_doc_recno'];
        $debt->debt_doc_recdate = $req['debt_doc_recdate'];        
        $debt->deliver_no = $req['deliver_no'];
        $debt->deliver_date = $req['deliver_date'];
        $debt->debt_doc_no = $req['debt_doc_no'];
        $debt->debt_doc_date = $req['debt_doc_date'];
        $debt->debt_type_id = $req['debt_type_id'];
        $debt->debt_type_detail = $req['debt_type_detail'];
        $debt->supplier_id = $req['supplier_id'];
        $debt->supplier_name = $req['supplier_name'];
        $debt->doc_receive = $req['doc_receive'];
        $debt->debt_year = $req['debt_year'];
        $debt->debt_amount = $req['debt_amount'];
        $debt->debt_vatrate = $req['debt_vatrate'];
        $debt->debt_vat = $req['debt_vat'];
        $debt->debt_total = $req['debt_total'];
        $debt->debt_remark = $req['debt_remark'];

        $debt->debt_creby = $req['debt_creby'];
        $debt->debt_credate = date("Y-m-d H:i:s");
        $debt->debt_userid = $req['debt_userid'];
        $debt->debt_chgdate = date("Y-m-d H:i:s");

        if($debt->save()) {
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

    public function delete($debtId)
    {
        $debt = Debt::find($debtId);

        if($debt->delete()) {
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

    public function setZero(Request $req)
    {
        if(Debt::where('debt_id', '=', $req['debt_id'])->update(['debt_status' => '4']) <> 0) {
            return [
                'status' => 'success',
                'message' => 'Updated id ' . $req['debt_id'] . 'is successed.',
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Updated id ' . $req['debt_id'] . 'is failed.',
            ];
        }
    }

    public function supplierDebt($creditor)
    {
        /** 0=รอดำเนินการ,1=ขออนุมัติ,2=ตัดจ่าย,3=ยกเลิก,4=ลดหนี้ศุนย์ */
        return [
            'assets' => Debt::where(['supplier_id' => $creditor])
                            ->where(['debt_status' => 0])
                            ->with('debttype')
                            ->paginate(10),
        ];
    }
}
