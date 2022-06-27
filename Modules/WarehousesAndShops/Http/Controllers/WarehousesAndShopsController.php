<?php

namespace Modules\WarehousesAndShops\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;
use Modules\WarehousesAndShops\Entities\WarehousesAndShops;
use Auth;
class WarehousesAndShopsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
    if (request()->ajax()) {
        $warehousesandshops=WarehousesAndShops::select('*')->orderBy('id','ASC')->get();
            return DataTables::of($warehousesandshops)
                ->addColumn('action', function ($row) {
                    $action='';
                if(Auth::user()->can('warehousesandshops.edit')){
                $action.='<a class="btn btn-primary btn-sm" href="'.url('warehousesandshops/edit/'.$row->id).'"><i class="fas fa-pencil-alt"></i></a>';
                }
                if(Auth::user()->can('warehousesandshops.delete')){
                $action.='<a class="btn btn-danger btn-sm" href="'.url('warehousesandshops/destroy/'.$row->id).'"><i class="fas fa-trash-alt"></i></a>';
                }
                return $action;
                })

                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('type', function ($row) {
                    return ucfirst($row->type);
                })

                ->rawColumns(['action'])
                ->make(true);
    }


        return view('warehousesandshops::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('warehousesandshops::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $req)
    {
        $req->validate([
            'name'=>'required',
            'type'=>'required',
        ]);
       $input=$req->all();
       if(WarehousesAndShops::create($input)){
        return redirect('warehousesandshops')->with('success','Warehouse or Shop successfully created');
       }  
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('warehousesandshops::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {

        $this->data['warehousesandshops']=WarehousesAndShops::find($id);
        return view('warehousesandshops::edit')->withData($this->data);

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Req $req, $id)
    {
        $req->validate([
            'name'=>'required',
            'type'=>'required',
        ]);

        $warehousesandshops=WarehousesAndShops::find($id);
       if($warehousesandshops->update($req->all())){
            return redirect('warehousesandshops')->with('success','Warehouse or Shop successfully Updated');
       }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if(WarehousesAndShops::find($id)->delete()){
            return redirect()->back()->with('success','Warehouse or Shop successfully deleted');
        }
    }
}
