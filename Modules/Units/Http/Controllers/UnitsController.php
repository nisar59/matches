<?php

namespace Modules\Units\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;
use Modules\Units\Entities\Units;
use Auth;

class UnitsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
    if (request()->ajax()) {
        $units=Units::select('*')->orderBy('id','ASC')->get();
            return DataTables::of($units)
                ->addColumn('action', function ($row) {
                    $action='';
                if(Auth::user()->can('units.edit')){
                $action.='<a class="btn btn-primary btn-sm" href="'.url('units/edit/'.$row->id).'"><i class="fas fa-pencil-alt"></i></a>';
                }
                if(Auth::user()->can('units.delete')){
                $action.='<a class="btn btn-danger btn-sm" href="'.url('units/destroy/'.$row->id).'"><i class="fas fa-trash-alt"></i></a>';
                }
                return $action;
                })

                ->editColumn('name', function ($row) {
                    return $row->name;
                })

                ->rawColumns(['action'])
                ->make(true);
    }

        return view('units::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('units::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $req)
    {
        $req->validate([
            'name'=>'required ',
        ]);
       $input=$req->all();
       if(Units::create($input)){
        return redirect('units')->with('success','Unit successfully created');
       }    
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('units::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->data['units']=Units::find($id);
        return view('units::edit')->withData($this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $req, $id)
    {
        $cate=Units::find($id);
       if($cate->update($req->all())){
            return redirect('units')->with('success','Unit successfully updated');
       }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if(Units::find($id)->delete()){
            return redirect()->back()->with('success','Unit successfully deleted');
        }
    }
}
