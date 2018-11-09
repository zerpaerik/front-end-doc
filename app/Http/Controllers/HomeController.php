<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Helpers\LoginChecker;
use Illuminate\Routing\Redirector;
use Session;
use Cookie;

class HomeController extends Controller
{
    public function __construct(Redirector $redirect){
    	if(LoginChecker::check() !== true){                        
           $redirect->to('login')->send();                     
        }        
    }

    public function index()
    {
        return view('home');                            
    }        
}

