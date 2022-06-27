<?php

namespace Modules\Purchases\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Contacts\Entities\Contacts;
use Modules\Units\Entities\Units;
use Modules\Category\Entities\Category;
use Modules\Products\Entities\Products;
use Modules\Purchases\Entities\Purchases;
use Modules\Purchases\Entities\PurchasedProducts;
use Modules\Purchases\Entities\PurchasedProductsSubUnits;
use Modules\Transactions\Entities\Transactions;
use Modules\WarehousesAndShops\Entities\WarehousesAndShops;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
class PurchasesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
    if (request()->ajax()) {
        $purchases=Purchases::select('*')->orderBy('id','ASC')->get();
            return DataTables::of($purchases)
                ->addColumn('action', function ($row) {
                    $action='';
                if(Auth::user()->can('purchases.view')){
                $action.='<a class="btn btn-success btn-sm show" href="javascript:void(0)" data-href="'.url('purchases/show/'.$row->id).'"><i class="fas fa-eye"></i></a>';
                }
                if(Auth::user()->can('purchases.edit')){
                $action.='<a class="btn btn-primary btn-sm" href="'.url('purchases/edit/'.$row->id).'"><i class="fas fa-pencil-alt"></i></a>';
                }
                if(Auth::user()->can('purchases.delete')){
                $action.='<a class="btn btn-danger btn-sm" href="'.url('purchases/destroy/'.$row->id).'"><i class="fas fa-trash-alt"></i></a>';
                }
                return $action;
                })

                ->editColumn('vendor', function ($row) {
                    return '<a href="'.url('contacts/edit/'.$row->vendor).'">'.Contact($row->vendor).'</a>';
                })
                ->editColumn('order_date', function ($row) {
                    return $row->order_date;
                })
                ->editColumn('reference_no', function ($row) {
                    return $row->reference_no;               
                })
                ->editColumn('purchase_total', function ($row) {
                    return $row->purchase_total;
                })                
                ->editColumn('payment_amount', function ($row) {
                   return $row->payment_amount;
                })
                ->editColumn('due', function ($row) {

                   return $row->due;
                })
                ->editColumn('payment_status', function ($row) {

                    return '<a href="javascript:void(0)" class="btn btn-primary btn-sm payment-transactions" data-href="'.url('purchases/payment-transactions/'.$row->id).'">'.ucfirst($row->payment_status).'</a>';
                })
                ->editColumn('shipping_status', function ($row) {
                    return $row->shipping_status;
                })
                ->editColumn('added_by', function ($row) {
                return '<a href="'.url('users/edit/'.$row->added_by).'">'.User($row->added_by).'</a>';                
                })

                ->rawColumns(['vendor','added_by','payment_status','action'])
                ->make(true);
    }
        return view('purchases::index');
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


        $this->data['vendors']=Contacts::Where('contact_type','vendor')->get();
        $this->data['products']=Products::all();
        $this->data['units']=Units::all();
        $this->data['category']=Category::all();
        $this->data['warehousesandshops']=WarehousesAndShops::all();
        return view('purchases::create')->withData($this->data);
    }

    public function addsubunits($id)
    {
        $this->data['units']=Units::all();
        $this->data['proid']=$id;
        return view('purchases::sub-units')->withData($this->data);

    }

    public function payment_methods_fields(Request $req)
    {
        $this->data['method']=PaymentMethods()[$req->k];
       return view('purchases::payment-methods-fields')->withData($this->data);
    }


    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $req)
    {
        

        $req->validate([
            'vendor'=>'required',
            'order_date'=>'required',
            'warehousesandshops_id'=>'required',
            'reference_no'=>'required',
            'total_items'=>'required',
            'gross_total'=>'required',
            'shipping_status'=>'required',
            'product'=>'required',
            'quantity'=>'required',
            'price'=>'required',
            'payment_amount'=>'required',
        ]);
        
    DB::beginTransaction();
    try {

        $purch_inputs=$req->only(['vendor','order_date','reference_no','total_items','gross_total','purchase_total','payment_amount','due','discount_type','discount_value','net_discount','shipping_status','shipping_address','shipping_charges','shipping_detail']);


        $purch_inputs['added_by']=Auth::id();
        $purch_inputs['payment_status']=PaymentStatus($req->purchase_total, $req->payment_amount);
        $purch=Purchases::create($purch_inputs);
        $purch_products=$req->only([
        'product','warehousesandshops_id','quantity','price','pronet','subunits','subunitsquantity'
        ]);

        $purch_products['poi']=$purch->id;
        $pp=PurchasedProducts::AddPurchasedProAndSubUnits($purch_products);

        $paymtd=PaymentMethods()[$req->payment_method];

        $trans=[];
        $trans_meta=[];

        $trans_meta['method']=$req->payment_method;
        if(count($paymtd['fields'])>0){
            if($req->payment_method=='card'){
                $inp_name=$paymtd['fields']['input']['name'];
                $sel_name=$paymtd['fields']['select']['name'];
                $trans_meta['details'][$inp_name]=$req->$inp_name;
                $trans_meta['details'][$sel_name]=$req->$sel_name;
            }
            else{
                $inp_name=$paymtd['fields']['input']['name'];
                $trans_meta['details'][$inp_name]=$req->$inp_name;

            }
        }

        $trans=[
                "model_id"=>$purch->id,
                "transaction_type"=>"purchase",
                "payment_amount"=>$req->payment_amount,
                "paid_on"=>$req->payment_date,
                "method"=>$req->payment_method,
                "method_detail"=>json_encode($trans_meta),
                "note"=>$req->payment_note,
        ];

        Transactions::create($trans);
        DB::commit();
            return redirect('purchases')->with('success', 'Purchase successfully created');

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error', 'something wrong');
        }


    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        $purchase=Purchases::find($id);
        return view('purchases::show')->withData($purchase);
    }

    public function paymenttransactions($id)
    {
        $purchase=Purchases::find($id);
        return view('purchases::payment-transaction')->withData($purchase);
    }


    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        if(request()->ajax()){
            $this->data['pro']=Products::find(request()->id);
        return view('purchases::product')->withData($this->data);
        }

        $this->data['vendors']=Contacts::Where('contact_type','vendor')->get();
        $this->data['products']=Products::all();
        $this->data['units']=Units::all();
        $this->data['category']=Category::all();
        $this->data['purchase']=Purchases::find($id);
        $this->data['warehousesandshops']=WarehousesAndShops::all();
        return view('purchases::edit')->withData($this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $req, $id)
    {


        $req->validate([
            'vendor'=>'required',
            'order_date'=>'required',
            'warehousesandshops_id'=>'required',
            'reference_no'=>'required',
            'total_items'=>'required',
            'gross_total'=>'required',
            'shipping_status'=>'required',
            'product'=>'required',
            'quantity'=>'required',
            'price'=>'required',
        ]);
        
    DB::beginTransaction();
    try {

        $purch_inputs=$req->only(['vendor','order_date','reference_no','total_items','gross_total','purchase_total','discount_type','discount_value','net_discount','shipping_status','shipping_address','shipping_charges','shipping_detail']);


        $purch_inputs['added_by']=Auth::id();

        $purch=Purchases::find($id);

        $purch_inputs['payment_status']=PaymentStatus($req->purchase_total, $purch->payment_amount);
        $purch_inputs['due']=$req->purchase_total-$purch->payment_amount;

        $purch->update($purch_inputs);
        

        $purch_products=$req->only([
        'product','warehousesandshops_id','quantity','price','pronet','subunits','subunitsquantity'
        ]);

        $purch_products['poi']=$id;

        $getpp=PurchasedProducts::where('purchase_order_id',$id);
        if($getpp->count()>0){
            $getpp->delete();
        }
        $pp=PurchasedProducts::AddPurchasedProAndSubUnits($purch_products);

        DB::commit();
            return redirect('purchases')->with('success', 'Purchase successfully updated');

        } catch (\Exception $ex) {
            DB::rollback();
            return redirect()->back()->with('error', 'something wrong');
        }
        
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
    try {
        $purch=Purchases::find($id);
        $purch->delete();
        return redirect('purchases')->with('success', 'Purchase successfully deleted');

        } catch (Exception $e) {

            return redirect('error')->with('error', 'Something went wrong');

        }
        

    }

    public function removesubunit($id)
    {
        try {
            PurchasedProductsSubUnits::find($id)->delete();
            return '1';
        } catch (Exception $e) {
            return '0';
        }

    }

    public function removepro($id)
    {
        try {
            $pp=PurchasedProducts::find($id);
            $poi=$pp->purchase_order_id;
            $pp->delete();

            $qnty=PurchasedProducts::where('purchase_order_id',$poi)->sum('quantity');
            $gt=PurchasedProducts::where('purchase_order_id',$poi)->sum('total_product_cost');
            
            $purch=Purchases::find($poi);

            $purch_total=($gt+$purch->shipping_charges)+$purch->net_discount;

            $purch->update([
                'gross_total'=>$gt,
                'total_items'=>$qnty,
                'purchase_total'=>$purch_total,
            ]);


            return '1';
        } catch (Exception $e) {
            return '0';
        }
    }

}
