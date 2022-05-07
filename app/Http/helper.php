<?php
use Modules\Settings\Entities\Settings;
function AllPermissions()
{
	$role=[];
	$role['users']=['view','add','edit','delete'];
	$role['permissions']=['view','add','edit','delete'];
	$role['settings']=['view','add','edit','delete'];


return $role;

}

function FileUpload($img, $path){
	if($img==null){return null;}
	 $imgname=$img->getClientOriginalName();
	  if($img->move($path,$imgname)){
	  	return $imgname;
	  }
	  else{
	  	return null;
	  }
}

function Settings()
{
	return Settings::first();
}
