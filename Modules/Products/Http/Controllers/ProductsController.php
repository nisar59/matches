<?php

namespace Modules\Products\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Units\Entities\Units;
use Modules\Category\Entities\Category;
use Modules\Products\Entities\Products;
use Modules\WarehousesAndShops\Entities\WarehousesAndShops;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use Mpdf\Mpdf;
class ProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

    if (request()->ajax()) {
        $req=request();
        $products=Products::select('*')->orderBy('id','ASC');

            if($req->name!=null){
                $products->where('name',$req->name);
            }
            if($req->sku!=null){
                $products->where('sku',$req->sku);
            }
            if($req->category!=null){
                $products->where('category',$req->category);
            }
            if($req->unit!=null){
                $products->where('pricing_unit',$req->unit);
            }
            $products->get();
            
            return DataTables::of($products)
                ->addColumn('action', function ($row) {
                    $action='';
                if(Auth::user()->can('products.edit')){
                $action.='<a class="btn btn-primary btn-sm" href="'.url('products/edit/'.$row->id).'"><i class="fas fa-pencil-alt"></i></a>';
                }
                if(Auth::user()->can('products.delete')){
                $action.='<a class="btn btn-danger btn-sm" href="'.url('products/destroy/'.$row->id).'"><i class="fas fa-trash-alt"></i></a>';
                }
                return $action;
                })
                ->addColumn('image', function ($row) {
                    $path=public_path('img');
                    $url=url('img');
                    $img=$url.'/images.png';
                    if(file_exists($path.'/products/'.$row->image) AND $row->image!=null){
                    $img=$url.'/products/'.$row->image;
                    }

                    return '<img src="'.$img.'" height="50" width="50">';
                })
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('sku', function ($row) {
                    return $row->sku;
                })
                ->editColumn('pricing_unit', function ($row) {
                    if($row->UnitRel!=null){
                    return $row->UnitRel->name;
                    }                
                })
                ->editColumn('price', function ($row) {
                    return $row->price;                
                })
                ->editColumn('category', function ($row) {
                    if($row->CategoryRel!=null){
                    return $row->CategoryRel->name;
                    }
                })

                ->rawColumns(['image','action'])
                ->make(true);
    }
        $this->data['units']=Units::all();
        $this->data['category']=Category::all();
        return view('products::index')->withData($this->data);
    }

    public function stockreport()
    {

    if (request()->ajax()) {
        $req=request();
        $products=Products::has('ProductsStock')->with('ProductsStock')->select('*')->orderBy('id','ASC');

            if($req->name!=null){
                $products->where('name',$req->name);
            }
            if($req->sku!=null){
                $products->where('sku',$req->sku);
            }
            if($req->category!=null){
                $products->where('category',$req->category);
            }
            if($req->unit!=null){
                $products->where('pricing_unit',$req->unit);
            }
            $products->get();
            
            return DataTables::of($products)

                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('sku', function ($row) {
                    return $row->sku;
                })
                ->editColumn('pricing_unit', function ($row) {
                    if($row->UnitRel!=null){
                    return $row->UnitRel->name;
                    }                
                })
                ->editColumn('price', function ($row) {
                    if($row->ProductsStock!=null){
                    return $row->ProductsStock->first()->unit_cost;
                    }                
                })
                ->editColumn('category', function ($row) {
                    if($row->CategoryRel!=null){
                    return $row->CategoryRel->name;
                    }
                })
                ->editColumn('available_quantity', function ($row) {
                    if($row->ProductsStock!=null){
                    return $row->ProductsStock->sum('available_quantity');
                    }
                })
                ->editColumn('sold_quantity', function ($row) {
                    if($row->ProductsStock!=null){
                    return $row->ProductsStock->sum('sold_quantity');
                    }
                })

                ->make(true);
    }
        $this->data['units']=Units::all();
        $this->data['category']=Category::all();
        return view('products::stock-report')->withData($this->data);
    }

    public function pdfexport()
    {
        $this->data['products']=Products::all();
        $html=view('products::export-pdf')->withData($this->data)->render();

        $mpdf = new Mpdf(['orientation'=>'L',]);
        $mpdf->AddPageByArray([
            'margin-left' => 5,
            'margin-right' => 5,
            'margin-top' => 2,
            'margin-bottom' => 0,
        ]);
        $mpdf->WriteHTML($html);
        $mpdf->Output();
    }



    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->data['units']=Units::all();
        $this->data['category']=Category::all();
        return view('products::create')->withData($this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $req)
    {
        $path=public_path('img/products');

        $input=$req->except('image');
        $input['image']=FileUpload($req->file('image'),$path);
       if(Products::create($input)){
        return redirect('products')->with('success','Product successfully created');
       }    
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('products::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->data['units']=Units::all();
        $this->data['category']=Category::all();
        $this->data['product']=Products::find($id);
        return view('products::edit')->withData($this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $req, $id)
    {
        $path=public_path('img/products');

        $input=$req->except('image');
        if($req->file('image')!=null){
        $input['image']=FileUpload($req->file('image'),$path);
        }
       if(Products::find($id)->update($input)){
        return redirect('products')->with('success','Product successfully updated');
       }     }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if(Products::find($id)->delete()){
            return redirect()->back()->with('success','Product successfully deleted');
        }

    }
}
