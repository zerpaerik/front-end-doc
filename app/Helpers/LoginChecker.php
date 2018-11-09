<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Cookie;
use Session;

class LoginChecker {
 	
 	public static function check(){
        if(Cookie::has('token')){
        	self::keepSessions();
        	
        	return true;
        }
        return false;        
 	}

 	public static function keepSessions(){		
        Session::keep(['token', 'user', 'user_id', 'company_id', 'branch_office_id', 'country']);
    }
}