<?php

namespace Modules\StockTransfer\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Purchases\Entities\PurchasedProducts;
use Modules\WarehousesAndShops\Entities\WarehousesAndShops;
use Modules\Products\Entities\Products;
use Modules\StockTransfer\Entities\StockTransfer;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Carbon;
class StockTransferController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
    if (request()->ajax()) {

        $req=request();
        
        $stocktransfer=StockTransfer::select('*')->orderBy('id','ASC');

        if($req->reference_no!=null){
            $stocktransfer->where('transfer_reference_no',$req->reference_no);
        }

        if($req->shipping_status!=null){
            $stocktransfer->where('shipping_status',$req->shipping_status);
        }
        if($req->transfer_date!=null){
            $daterange=explode('-', $req->transfer_date);
            $from=Carbon::parse($daterange[0])->format('Y-m-d');
            $to=Carbon::parse($daterange[1])->format('Y-m-d');

            $stocktransfer->whereDate('transfer_date','>=',$from)->whereDate('transfer_date','<=',$to);   
        }

        $stocktransfer->get();

            return DataTables::of($stocktransfer)
                ->addColumn('action', function ($row) {
                    $action='';
                if(Auth::user()->can('stocktransfer.view')){
                $action.='<a class="btn btn-success btn-sm show" href="javascript:void(0)" data-href="'.url('stocktransfer/show/'.$row->id).'"><i class="fas fa-eye"></i></a>';
                }
                if(Auth::user()->can('stocktransfer.delete')){
                $action.='<a class="btn btn-danger btn-sm" href="'.url('stocktransfer/destroy/'.$row->id).'"><i class="fas fa-trash-alt"></i></a>';
                }
                return $action;
                })
                ->editColumn('transfer_date', function ($row) {
                    return $row->transfer_date;
                })
                ->editColumn('transfer_reference_no', function ($row) {
                    return $row->transfer_reference_no;               
                })
                ->editColumn('transfer_quantity', function ($row) {
                    return number_format($row->transfer_quantity,2);
                })                
                ->editColumn('transfer_charges', function ($row) {
                   return number_format($row->transfer_charges,2);
                })
                ->editColumn('transfer_total', function ($row) {

                   return number_format($row->transfer_total,2);
                })
                ->editColumn('shipping_status', function ($row) {
                    return $row->shipping_status;
                })
                ->editColumn('added_by', function ($row) {
                return '<a href="'.url('users/edit/'.$row->added_by).'">'.User($row->added_by).'</a>';                
                })

                ->rawColumns(['added_by','action'])
                ->make(true);
    }
        return view('stocktransfer::index');
    }

    public function report()
    {
    if (request()->ajax()) {

        $req=request();
        
        $stocktransfer=StockTransfer::select('*')->orderBy('id','ASC');

        if($req->reference_no!=null){
            $stocktransfer->where('transfer_reference_no',$req->reference_no);
        }

        if($req->shipping_status!=null){
            $stocktransfer->where('shipping_status',$req->shipping_status);
        }
        if($req->transfer_date!=null){
            $daterange=explode('-', $req->transfer_date);
            $from=Carbon::parse($daterange[0])->format('Y-m-d');
            $to=Carbon::parse($daterange[1])->format('Y-m-d');

            $stocktransfer->whereDate('transfer_date','>=',$from)->whereDate('transfer_date','<=',$to);   
        }

        $stocktransfer->get();

            return DataTables::of($stocktransfer)
                ->editColumn('transfer_date', function ($row) {
                    return $row->transfer_date;
                })
                ->editColumn('transfer_reference_no', function ($row) {
                    return $row->transfer_reference_no;               
                })
                ->editColumn('transfer_quantity', function ($row) {
                    return number_format($row->transfer_quantity,2);
                })                
                ->editColumn('transfer_charges', function ($row) {
                   return number_format($row->transfer_charges,2);
                })
                ->editColumn('transfer_total', function ($row) {

                   return number_format($row->transfer_total,2);
                })
                ->editColumn('shipping_status', function ($row) {
                    return $row->shipping_status;
                })
                ->editColumn('added_by', function ($row) {
                return '<a href="'.url('users/edit/'.$row->added_by).'">'.User($row->added_by).'</a>';                
                })

                ->rawColumns(['added_by'])
                ->make(true);
    }
        return view('stocktransfer::stock-report');
    }


    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {

        if(request()->ajax()){
        $this->data['pro']=Products::find(request()->id);
        return view('purchases::product')->withData($this->data);
        }
        
        $this->data['warehousesandshops']=WarehousesAndShops::all();
        $this->data['products']=Products::all();
        return view('stocktransfer::create')->withData($this->data);
    }


    public function search(Request $req)
    {
        $pp=PurchasedProducts::with('productRel')->where('product_id', $req->id)->where('warehousesandshops_id', $req->whspid)->where('available_quantity','>',0)->first();

        if($pp==null){
            return 'false';
        }
        else{
            return view('stocktransfer::product-row')->withData($pp);
        }
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $req)
    {
        //dd($req->all());

        if($req->to_wherehouseshope_id==$req->from_wherehouseshope_id){
            return redirect()->back()->with('warning', "Stock can't be transfered to same Warehouse or Shop");
        }
        $stt=StockTransfer::create([
        "transfer_date"=>$req->transfer_date,
        "transfer_reference_no"=>$req->transfer_reference_no,
        "transfer_quantity"=>$req->total_quantity,
        "transfer_charges"=>$req->transfer_charges,
        "transfer_note"=>$req->additional_note,
        "shipping_status"=>$req->shipping_status,
        "transfer_total"=>$req->total_amount,
        "added_by"=>Auth::user()->id,
        ]);
        
        $products=$req->product_id;
        foreach($products as$key=> $pro){
            $pp=PurchasedProducts::find($pro);
            $availbaleqty=$pp->available_quantity;
            $qnty=$req->quantity[$key];
            $newpp=$pp->toArray();
            $tpc=$pp->unit_cost*$qnty;
            unset($newpp['id']);
            unset($newpp['created_at']);
            unset($newpp['updated_at']);
            unset($newpp['purchase_order_id']);
            $newpp['warehousesandshops_id']=$req->to_wherehouseshope_id;
            $newpp['transfer_id']=$stt->id;

            $newpp['type']="transfer";
            $newpp['quantity']=$qnty;
            $newpp['available_quantity']=$qnty;
            $newpp['total_product_cost']=$tpc;
            $newpp['parent_id']=$pp->id;
            
            if($availbaleqty>$qnty){
               PurchasedProducts::create($newpp);
               $pp->update([
                "available_quantity"=>$availbaleqty-$qnty,
                "transfer_quantity"=>$qnty,
               ]);

            }

        }

        return redirect("stocktransfer")->with("success", "Stock Transfered");
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $towarehouse_id=0;
        $fromwarehouse_id=0;
        $stock=StockTransfer::find($id);
       if($stock->StockTransfered->count()>0){
        $towarehouse_id=$stock->StockTransfered->first()->warehousesandshops_id;
        $pp=PurchasedProducts::find($stock->StockTransfered->first()->parent_id);
        if($pp!=null){
        $fromwarehouse_id=$pp->warehousesandshops_id;
        }
       }
       $stock->setAttribute('fromwarehouse_id', $fromwarehouse_id);
       $stock->setAttribute('towarehouse_id', $towarehouse_id);

        return view('stocktransfer::show')->withData($stock);

    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('stocktransfer::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
    try {
        $stock=StockTransfer::find($id);
        $stock->delete();
        return redirect('stocktransfer')->with('success', 'Stock Transfer successfully deleted');

        } catch (Exception $e) {

            return redirect('stocktransfer')->with('error', 'Something went wrong');

        }
    }
}
