<?php

namespace App\Http\Controllers;
use App\Helpers\LoginChecker;
use App\Helpers\ValidateAccess;
use Illuminate\Routing\Redirector;

class CountryTaxController extends Controller
{
    public function __construct(Redirector $redirect){
        if(LoginChecker::check() !== true){                        
           $redirect->to('login')->send();                     
        }        
    }

	public function index()
    {
        if(ValidateAccess::checkAccess(env('MODULE_TAX', NULL), env('PERMISSION_READ', NULL)))
            return view('countrytax.index');
        else
            return redirect('error');
    }

    public function create()
    {
        if(ValidateAccess::checkAccess(env('MODULE_TAX', NULL), env('PERMISSION_CREATE', NULL)))
    	   return view('countrytax.create');
        else
            return redirect('error');
    }
    
    public function edit($id)
    {
        if(ValidateAccess::checkAccess(env('MODULE_TAX', NULL), env('PERMISSION_UPDATE', NULL)))
    	   return view('countrytax.edit', ['id'=>$id]);
        else
            return redirect('error');
    }
}