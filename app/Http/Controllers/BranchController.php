<?php

namespace App\Http\Controllers;
use App\Helpers\LoginChecker;
use App\Helpers\ValidateAccess;
use Illuminate\Routing\Redirector;

class BranchController extends Controller
{
    public function __construct(Redirector $redirect){        
        if(LoginChecker::check() !== true){                        
           $redirect->to('login')->send();            
        }        
    }

	public function index()
    {
        if(ValidateAccess::checkAccess(env('MODULE_BRANCH', NULL), env('PERMISSION_READ', NULL)))
            return view('branch.index');
        else
            return redirect('error');
    }

    public function create()
    {
        if(ValidateAccess::checkAccess(env('MODULE_BRANCH', NULL), env('PERMISSION_CREATE', NULL)))
    	   return view('branch.create');
        else
            return redirect('error');
    }    

    public function edit($id){
        if(ValidateAccess::checkAccess(env('MODULE_BRANCH', NULL), env('PERMISSION_UPDATE', NULL)))
            return view('branch.edit', compact('id'));
        else
            return redirect('error');
    }
}