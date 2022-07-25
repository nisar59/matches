<?php

namespace Modules\Expenses\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Expenses\Entities\Expenses;
use Modules\Transactions\Entities\Transactions;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use DB;
use Carbon;
class ExpensesController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
    if (request()->ajax()) {
        $req=request();
        $expenses=Expenses::select('*')->orderBy('id','ASC');
        
        if($req->expense_category!=null){
            $expenses->where('expense_category',$req->expense_category);
        }
        if($req->reference_no!=null){
            $expenses->where('reference_no',$req->reference_no);
        }
        if($req->payment_status!=null){
            $expenses->where('payment_status',$req->payment_status);
        }

        if($req->expense_date!=null){
            $daterange=explode('-', $req->expense_date);
            $from=Carbon::parse($daterange[0])->format('Y-m-d');
            $to=Carbon::parse($daterange[1])->format('Y-m-d');

            $expenses->whereDate('expense_date','>=',$from)->whereDate('expense_date','<=',$to);   
        }

            $expenses->get();
            return DataTables::of($expenses)
                ->addColumn('action', function ($row) {
                    $action='';
                if(Auth::user()->can('expenses.view')){
                $action.='<a class="btn btn-success btn-sm show" href="javascript:void(0)" data-href="'.url('expenses/show/'.$row->id).'"><i class="fas fa-eye"></i></a>';
                }
                if(Auth::user()->can('expenses.edit')){
                $action.='<a class="btn btn-primary btn-sm" href="'.url('expenses/edit/'.$row->id).'"><i class="fas fa-pencil-alt"></i></a>';
                }
                if(Auth::user()->can('expenses.delete')){
                $action.='<a class="btn btn-danger btn-sm" href="'.url('expenses/destroy/'.$row->id).'"><i class="fas fa-trash-alt"></i></a>';
                }
                return $action;
                })

                ->editColumn('expense_date', function ($row) {
                    return $row->expense_date;
                })
                ->editColumn('reference_no', function ($row) {
                    return $row->reference_no;               
                })
                ->editColumn('expense_category', function ($row) {
                    return $row->expense_category;
                })
                ->editColumn('amount', function ($row) {
                   return number_format($row->amount,2);
                })                
                ->editColumn('paid', function ($row) {
                   return number_format($row->paid,2);
                })
                ->editColumn('due', function ($row) {

                   return number_format($row->due,2);
                })
                ->editColumn('payment_status', function ($row) {

                    return '<a href="javascript:void(0)" class="btn btn-primary btn-sm payment-transactions" data-href="'.url('expenses/payment-transactions/'.$row->id).'">'.ucfirst($row->payment_status).'</a>';
                })
                ->editColumn('added_by', function ($row) {
                return '<a href="'.url('users/edit/'.$row->added_by).'">'.User($row->added_by).'</a>';                
                })

                ->rawColumns(['added_by','payment_status','action'])
                ->make(true);
    }


        return view('expenses::index');
    }


    public function report()
    {
    if (request()->ajax()) {
        $req=request();
        $expenses=Expenses::select('*')->orderBy('id','ASC');
        
        if($req->expense_category!=null){
            $expenses->where('expense_category',$req->expense_category);
        }
        if($req->reference_no!=null){
            $expenses->where('reference_no',$req->reference_no);
        }
        if($req->payment_status!=null){
            $expenses->where('payment_status',$req->payment_status);
        }

        if($req->expense_date!=null){
            $daterange=explode('-', $req->expense_date);
            $from=Carbon::parse($daterange[0])->format('Y-m-d');
            $to=Carbon::parse($daterange[1])->format('Y-m-d');

            $expenses->whereDate('expense_date','>=',$from)->whereDate('expense_date','<=',$to);   
        }

            $expenses->get();
            return DataTables::of($expenses)
                ->editColumn('expense_date', function ($row) {
                    return $row->expense_date;
                })
                ->editColumn('reference_no', function ($row) {
                    return $row->reference_no;               
                })
                ->editColumn('expense_category', function ($row) {
                    return $row->expense_category;
                })
                ->editColumn('amount', function ($row) {
                   return number_format($row->amount,2);
                })                
                ->editColumn('paid', function ($row) {
                   return number_format($row->paid,2);
                })
                ->editColumn('due', function ($row) {

                   return number_format($row->due,2);
                })
                ->editColumn('payment_status', function ($row) {

                    return '<a href="javascript:void(0)" class="btn btn-primary btn-sm payment-transactions" data-href="'.url('expenses/payment-transactions/'.$row->id).'">'.ucfirst($row->payment_status).'</a>';
                })
                ->editColumn('added_by', function ($row) {
                return '<a href="'.url('users/edit/'.$row->added_by).'">'.User($row->added_by).'</a>';                
                })

                ->rawColumns(['added_by','payment_status'])
                ->make(true);
    }


        return view('expenses::report');
    }

    /**
     * Show the form9 for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('expenses::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $req)
    {
        //dd($req->all());

    DB::beginTransaction();
    try {

        $input=$req->all();
        $input['payment_status']=PaymentStatus($req->amount,$req->paid);
        $input['due']=$req->amount-$req->paid;
        $input['added_by']=Auth::user()->id;

        $expense=Expenses::create($input);

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
                "model_id"=>$expense->id,
                "transaction_type"=>"expense",
                "payment_amount"=>$req->paid,
                "paid_on"=>$req->expense_date,
                "method"=>$req->payment_method,
                "method_detail"=>json_encode($trans_meta),
                "note"=>$req->note,
        ];

        Transactions::create($trans);
        DB::commit();
            return redirect('expenses')->with('success', 'Expense successfully created');

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
        return view('expenses::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $expense=Expenses::find($id);
        return view('expenses::edit')->withData($expense);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $req, $id)
    {

    DB::beginTransaction();
    try {
        $expense=Expenses::find($id);

        $input=$req->all();
        $input['payment_status']=PaymentStatus($req->amount,$expense->paid);
        $input['due']=$req->amount-$expense->paid;
        $input['added_by']=Auth::user()->id;
        
        $expense->update($input);

        DB::commit();
            return redirect('expenses')->with('success', 'Expense successfully Updated');

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
        $expense=Expenses::find($id);
        $expense->delete();
        return redirect('expenses')->with('success', 'Expense successfully deleted');

        } catch (Exception $e) {

            return redirect('expenses')->with('error', 'Something went wrong');

        }

    }
}
