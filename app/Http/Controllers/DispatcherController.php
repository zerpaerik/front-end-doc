<?php

namespace App\Http\Controllers;
use App\Helpers\LoginChecker;
use App\Helpers\ValidateAccess;
use Illuminate\Routing\Redirector;

class DispatcherController extends Controller
{
    public function __construct(Redirector $redirect){
        if(LoginChecker::check() !== true){                        
           $redirect->to('login')->send();                     
        }        
    }
    
	public function index()
    {
        if(ValidateAccess::checkAccess(env('MODULE_DISPATCHER', NULL), env('PERMISSION_READ', NULL)))
            return view('dispatcher.index');
        else
            return redirect('error');
    }

    public function create()
    {
        if(ValidateAccess::checkAccess(env('MODULE_DISPATCHER', NULL), env('PERMISSION_CREATE', NULL)))
    	   return view('dispatcher.create');
        else
            return redirect('error');
    }
    
    public function edit($id)
    {
        if(ValidateAccess::checkAccess(env('MODULE_DISPATCHER', NULL), env('PERMISSION_UPDATE', NULL)))
    	   return view('dispatcher.edit', compact('id'));
        else
            return redirect('error');
    }
}
