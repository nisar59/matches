<?php

namespace Modules\Contacts\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Contacts\Entities\Contacts;
use Yajra\DataTables\Facades\DataTables;
use Auth;
class ContactsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {

    if (request()->ajax()) {
        $type=Request()->type;
        $contacts=Contacts::Where('contact_type',$type)->select('*')->orderBy('id','ASC')->get();
            return DataTables::of($contacts)
                ->addColumn('action', function ($row) {
                    $action='';
                if(Auth::user()->can('contacts.edit')){
                $action.='<a class="btn btn-primary btn-sm" href="'.url('contacts/edit/'.$row->id).'"><i class="fas fa-pencil-alt"></i></a>';
                }
                if(Auth::user()->can('contacts.delete')){
                $action.='<a class="btn btn-danger btn-sm" href="'.url('contacts/destroy/'.$row->id).'"><i class="fas fa-trash-alt"></i></a>';
                }
                return $action;
                })

                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('email', function ($row) {
                    return $row->email;
                })

                ->editColumn('phone_no', function ($row) {
                    return $row->phone_no;
                })
                ->editColumn('address', function ($row) {
                    return $row->address;
                })
                ->rawColumns(['action'])
                ->make(true);
    }




        return view('contacts::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('contacts::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $req, $type)
    {
        $req->validate([
            'name'=>'required',
            'email'=>['required','unique:contacts,email'],
            'phone_no'=>'required',
            'address'=>'required',
        ]);
       $input=$req->merge(['contact_type'=>$type])->all();
       if(Contacts::create($input)){
        return redirect('contacts?type='.$type)->with('success','Contact successfully created');
       }

    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('contacts::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->data['contact']=Contacts::find($id);
        return view('contacts::edit')->withData($this->data);
    }

    /**
     * Update the specified resource in storage.
     * @param Request $request
     * @param int $id
     * @return Renderable
     */
    public function update(Request $req, $id)
    {
        $cont=Contacts::find($id);
       if($cont->update($req->all())){
            return redirect('contacts?type='.$cont->contact_type)->with('success','Contact successfully updated');
       }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
        if(Contacts::find($id)->delete()){
            return redirect()->back()->with('success','Contact successfully deleted');
        }
    }
}
