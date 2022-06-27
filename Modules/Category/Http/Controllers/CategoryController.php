<?php

namespace Modules\Category\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Yajra\DataTables\Facades\DataTables;
use Modules\Category\Entities\Category;
use Auth;
class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
    if (request()->ajax()) {
        $category=Category::select('*')->orderBy('id','ASC')->get();
            return DataTables::of($category)
                ->addColumn('action', function ($row) {
                    $action='';
                if(Auth::user()->can('category.edit')){
                $action.='<a class="btn btn-primary btn-sm" href="'.url('category/edit/'.$row->id).'"><i class="fas fa-pencil-alt"></i></a>';
                }
                if(Auth::user()->can('category.delete')){
                $action.='<a class="btn btn-danger btn-sm" href="'.url('category/destroy/'.$row->id).'"><i class="fas fa-trash-alt"></i></a>';
                }
                return $action;
                })

                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->rawColumns(['action'])
                ->make(true);
    }

        return view('category::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('category::create');
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
        ]);
       $input=$req->all();
       if(Category::create($input)){
        return redirect('category')->with('success','Category successfully created');
       }    
   }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('category::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->data['category']=Category::find($id);
        return view('category::edit')->withData($this->data);

    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $req, $id)
    {
        $cate=Category::find($id);
       if($cate->update($req->all())){
            return redirect('category')->with('success','Category successfully updated');
       }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if(Category::find($id)->delete()){
            return redirect()->back()->with('success','Category successfully deleted');
        }
    }
}
