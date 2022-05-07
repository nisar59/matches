<?php

namespace Modules\Settings\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Settings\Entities\Settings;
class SettingsController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return Renderable
     */
    public function index()
    {
        $this->data['settings']=Settings::first();
        return view('settings::index')->withData($this->data);
    }

    /**
     * Show the form for creating a new resource.
     * @return Renderable
     */
    public function create()
    {
        return view('settings::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param Request $request
     * @return Renderable
     */
    public function store(Request $req)
    {

        $portal_logo=null;
        $portal_favicon=null;
        $path=public_path('img/settings/');

        $sett=Settings::first();

        if($sett!=null){
            $portal_logo=$sett->portal_logo;
            $portal_favicon=$sett->portal_favicon;
        }

        if($req->file('panel_logo')!=null){
            $portal_logo=FileUpload($req->file('panel_logo'), $path);
        }
        if($req->file('panel_favicon')!=null){
            $portal_favicon=FileUpload($req->file('panel_favicon'), $path);
        }

        $settings=Settings::firstOrNew(['id'=>1]);
        $settings->portal_name=$req->panel_name;
        $settings->portal_email=$req->panel_email;
        $settings->inventory_expire_time=$req->inventory_expire_time;
        $settings->portal_logo=$portal_logo;
        $settings->portal_favicon=$portal_favicon;

        if($settings->save()){
            return redirect()->back()->with('success', 'Panel settings successfully saved');
        }
    }


    public function theme(Request $req)
    {
        $set=Settings::firstOrNew(['id'=>1]);

        if($req->field=='layout'){
        $set->layout=$req->data; 
        }
        if($req->field=='sidebar'){
        $set->sidebar_color=$req->data; 
        }
        if($req->field=='theme'){
        $set->color_theme=$req->data; 
        }
        if($req->field=='mini'){
        $set->mini_sidebar=$req->data; 
        }
        if($req->field=='sticky'){
        $set->sticky_header=$req->data; 
        }

        $set->save();

        return 'success';
    }
    public function restorydefault(Request $req)
    {
        $layout=1;
        $sidebar=1;
        $theme='white';
        $mini='unchecked';
        $sticky='checked';

        $set=Settings::firstOrNew(['id'=>1]);

        $set->layout=$layout; 
        $set->sidebar_color=$sidebar; 

        $set->color_theme=$theme; 

        $set->mini_sidebar=$mini; 

        $set->sticky_header=$sticky; 


        $set->save();

        return 'success';
    }

    /**
     * Show the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function show($id)
    {
        return view('settings::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @param int $id
     * @return Renderable
     */
    public function edit($id)
    {
        return view('settings::edit');
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
        //
    }
}
