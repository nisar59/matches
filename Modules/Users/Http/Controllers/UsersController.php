<?php

namespace Modules\Users\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\User;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;
use Auth;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        //dd(Auth::user()->roles[0]->name);
    if (request()->ajax()) {
        $users=User::with('roles')->select('id','name','email')->orderBy('id','ASC')->get();
            return DataTables::of($users)
                ->addColumn('action', function ($row) {
                    $action='';

                if(Auth::user()->hasRole('super-admin') AND $row->hasRole('super-admin')){
                $action.='<a class="btn btn-primary btn-sm" href="'.url('users/edit/'.$row->id).'"><i class="fas fa-pencil-alt"></i></a>';

                }
                elseif($row->hasRole('super-admin'))
                {
                    return '';
                }
                    else{
                if(Auth::user()->can('users.edit')){
                $action.='<a class="btn btn-primary btn-sm" href="'.url('users/edit/'.$row->id).'"><i class="fas fa-pencil-alt"></i></a>';
                }
                if(Auth::user()->can('users.delete')){
                $action.='<a class="btn btn-danger btn-sm" href="'.url('users/destroy/'.$row->id).'"><i class="fas fa-trash-alt"></i></a>';
                    }
                }
                return $action;
                })
                ->addColumn('role', function ($row) {
                    return $row->roles[0]->name;
                })
                ->editColumn('name', function ($row) {
                    return $row->name;
                })
                ->editColumn('email', function ($row) {
                    return $row->email;
                })
                ->removeColumn('id')
                ->rawColumns(['action','role'])
                ->make(true);
    }


        return view('users::index');    
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        $this->data['role']=Role::where('name','!=','super-admin')->get();
        return view('users::create')->withData($this->data);
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $req)
    {
        $req->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
            'role' => ['required'],
        ]);

        $path=public_path('img/users');

        $user=User::create([
            'name' => $req->name,
            'email' => $req->email,
            'password' => Hash::make($req->password),
            'image'=>FileUpload($req->file('image'), $path)
        ]);
        if($user->assignRole($req->role)){
            return redirect('users')->with('success', 'User successfully created');
        }
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('users::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        $this->data['role']=Role::where('name','!=','super-admin')->get();
        $this->data['user']=User::with('roles')->find($id);
        return view('users::edit')->withData($this->data);
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
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'role' => ['required'],
        ]);
        $path=public_path('img/users');

        $user=User::find($id);
        $user->name=$req->name;
        $user->email=$req->email;
        if($req->password!=null){
        $user->password=Hash::make($req->password);
        }
        if($req->file('image')!=null){
        $user->image=FileUpload($req->file('image'), $path);
        }
        $user->save();
        $user->roles()->detach();
        if($user->assignRole($req->role)){
            return redirect('users')->with('success', 'User successfully Updated');
        }
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return Renderable
     */
    public function destroy($id)
    {
       $user=User::find($id);
       $user->roles()->detach();
        User::find($id)->delete();
        return redirect('users')->with('success','User successfully deleted');

    }
}
