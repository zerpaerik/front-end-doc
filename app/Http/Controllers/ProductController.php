<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\LoginChecker;
use App\Helpers\ValidateAccess;
use Illuminate\Routing\Redirector;

class ProductController extends Controller
{
    public function __construct(Redirector $redirect){
        if(LoginChecker::check() !== true){                        
           $redirect->to('login')->send();                     
        }
    }
    
    public function index()
    {        
        if(ValidateAccess::checkAccess(env('MODULE_PRODUCT', NULL), env('PERMISSION_READ', NULL)))
            return view('product.index');
        else
            return redirect('error');
    }

    public function create()
    {                   
        if(ValidateAccess::checkAccess(env('MODULE_PRODUCT', NULL), env('PERMISSION_CREATE', NULL)))
    	   return view('product.create');
        else
            return redirect('error');
    }

    public function edit($id){
        if(ValidateAccess::checkAccess(env('MODULE_PRODUCT', NULL), env('PERMISSION_UPDATE', NULL)))
            return view('product.edit', compact('id'));
        else
            return redirect('error');
    }

    public function import(){
        return view('product.import');
    }
}
