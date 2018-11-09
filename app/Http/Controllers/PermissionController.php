<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\LoginChecker;
use App\Helpers\ValidateAccess;

class PermissionController extends Controller
{
	public function index(){
		if(ValidateAccess::checkAccess(env('MODULE_PERMISSION', NULL), env('PERMISSION_READ', NULL)))
			return view('permission.index');
		else
            return redirect('error');
	}

	public function index2(){
		
		return view('permission.index2');
		
	}

	public function create(){
		if(ValidateAccess::checkAccess(env('MODULE_PERMISSION', NULL), env('PERMISSION_CREATE', NULL)))
			return view('permission.create');
		else
            return redirect('error');
	}

	public function edit($id){
		if(ValidateAccess::checkAccess(env('MODULE_PERMISSION', NULL), env('PERMISSION_UPDATE', NULL)))
			return view('permission.edit', compact('id'));
		else
            return redirect('error');
	}
}
