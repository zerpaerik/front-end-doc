<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\LoginChecker;
use App\Helpers\ValidateAccess;
use Illuminate\Routing\Redirector;

class AuditController extends Controller
{
	public function __construct(Redirector $redirect){        
        if(LoginChecker::check() !== true){                        
           $redirect->to('login')->send();            
        }        
    }

    public function index(){
    	if(ValidateAccess::checkAccess(env('MODULE_AUDIT', NULL), env('PERMISSION_READ', NULL)))
            return view('audit.index');
        else
            return redirect('error');
    }
}
