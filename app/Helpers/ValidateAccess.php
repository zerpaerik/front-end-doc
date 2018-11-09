<?php

namespace App\Helpers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Response;
use Cookie;
use GuzzleHttp\Client;
use Session;

class ValidateAccess {
 	
 	public static function checkAccess($module, $action){        
        $user = $_COOKIE['user_id'];                     
        
        $client = new Client();
        $response = $client->post('' . env('API_HOST', NULL). '/checkAccess', 
                            array(
                                'headers'   =>  array('Content-Type'=>'application/json'),
                                'json'      =>  array(
                                                    'user'    => $user,
                                                    'module'  => $module, 
                                                    'action'  => $action
                                                )
                            )
                    );                    
                
        if($response->getStatusCode() == 200){                   
            $response->getBody()->rewind();
            $access = json_decode($response->getBody()->getContents());

            if($access == 1){                
            	return true;
            }
            else{
            	return false;
            }
        }
 	}
}