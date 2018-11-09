<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use GuzzleHttp\Client;
use Cookie;
use Session;

class LoginController extends Controller
{
    public function auth(Request $request){                 

        $client = new Client();
        session_start();
        
        try{
            $response = $client->post('' . env('API_HOST', NULL). '/authenticate', 
                            array(
                                'headers'   =>  array('Content-Type'=>'application/json'),
                                'json'      =>  array(
                                                    'email'     => $request['email'], 
                                                    'password'  => $request['password']
                                                )
                            )
                    );                    
                
            if($response->getStatusCode() == 200){                   
                $response->getBody()->rewind();
                $authObject     = json_decode($response->getBody()->getContents());
                
                $token          = $authObject->token;
                $userName       = $authObject->userName;
                $userId         = $authObject->userId;
                $company        = $authObject->company;
                $branch_office  = $authObject->branch_office;
                $country        = $authObject->country;

                $tokenCookie    = Cookie::make('token',            $authObject->token,              120, '/', ''.env('API_URL', NULL), false, true);
                $userCookie     = Cookie::make('user',             $authObject->userName,           120, '/', ''.env('API_URL', NULL), false, true);
                $userIdCookie   = Cookie::make('user_id',          $authObject->userId,             120, '/', ''.env('API_URL', NULL), false, true);
                $companyCookie  = Cookie::make('company_id',       $authObject->company,            120, '/', ''.env('API_URL', NULL), false, true);
                $branchCookie   = Cookie::make('branch_office_id', $authObject->branch_office,      120, '/', ''.env('API_URL', NULL), false, true);
                $country        = Cookie::make('country',          $authObject->country,            120, '/', ''.env('API_URL', NULL), false, true);
                $userRole       = Cookie::make('userRole',          $authObject->userRole,          120, '/', ''.env('API_URL', NULL), false, true);

                return response()
                            ->json(compact('token', 'userName', 'userId', 'company', 'branch_office', 'country', 'userRole'))
                            ->withCookie($tokenCookie)
                            ->withCookie($userCookie)
                            ->withCookie($userIdCookie)
                            ->withCookie($companyCookie)
                            ->withCookie($branchCookie)
                            ->withCookie($country)
                            ->withCookie($userRole);
            }
        }
        catch(Exception $e){
            return response('Usuario/Contraseña incorrectos', 401);
        }

    }

    public function login(){
        if(!Cookie::has('token')){
            return view('login.login');    
        }
        return redirect('home');        
    }

    public function logOut(){        
        Cookie::queue(
            Cookie::forget('token'),
            Cookie::forget('user'),
            Cookie::forget('user_id'),
            Cookie::forget('company_id'),
            Cookie::forget('branch_office_id')
        );

        Session::flush();
        return redirect('login');
    }    
}
