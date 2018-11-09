<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Helpers\LoginChecker;
use App\Helpers\ValidateAccess;
use Illuminate\Routing\Redirector;
use Cookie;

class UserController extends Controller
{
    public function __construct(Redirector $redirect){
        if(LoginChecker::check() !== true){                        
           $redirect->to('login')->send();                     
        }
    }

    public function index()
    {
        if(ValidateAccess::checkAccess(env('MODULE_USER', NULL), env('PERMISSION_READ', NULL)))
            return view('user.index');
        else
            return redirect('error');
    }

    public function create()
    {
        if(ValidateAccess::checkAccess(env('MODULE_USER', NULL), env('PERMISSION_CREATE', NULL))){
            $id = Cookie::get('company_id');
            return view('user.create', compact('id'));
        }
        else
            return redirect('error');
    }    

    public function edit($id){
        if(ValidateAccess::checkAccess(env('MODULE_USER', NULL), env('PERMISSION_UPDATE', NULL)))
            return view('user.edit', compact('id'));
        else
            return redirect('error');
    }
}
