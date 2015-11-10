<?php

namespace resapi\controller;

use resapi\libraries\Base;
use resapi\libraries\Config;
use resapi\libraries\APITokenAuth;
use resapi\models\ModelAuth;

class ControllerAuth extends Base {

	private function getDB(){
		return new ModelAuth();
	}

	public function loginToGetToken(){
		try{
        	$request = json_decode($this->request->getBody());

	        $email = isset($request->email) ? filter_var($request->email, FILTER_SANITIZE_STRING) : false;
	        $encryptPass = isset($request->password) ? filter_var($request->password, FILTER_SANITIZE_STRING) : false;
	        $password = mcrypt_decrypt(MCRYPT_DES, Config::PRIVATE_KEY, $this->safeHexToString($encryptPass) , MCRYPT_MODE_ECB);

	        $getToken = $this->getDB()->where('email', '=', $email)
	        						  ->where('password', '=', sha1($password))
	        						  ->first()->toArray();
			if($getToken != null){
            	$this->writeToJSON(['token' => $getToken['token']], 201);
			} else{
                $this->writeToJSON(['errmsg' => 'not found'], 204);
            }
		} catch(\Exception $ex){
			$this->writeToJSON(['errmsg' => 'service unavailable'], 503);
		}
	}

	public function registerNewUser(){
		try{
			$request = json_decode($this->request->getBody());

			$fullname = isset($request->fullname) ? filter_var($request->fullname, FILTER_SANITIZE_STRING) : false;
	        $email = isset($request->email) ? filter_var($request->email, FILTER_SANITIZE_STRING) : false;
	        $password = mcrypt_decrypt(MCRYPT_DES, Config::PRIVATE_KEY, $this->safeHexToString(filter_var($request->password, FILTER_SANITIZE_STRING)) , MCRYPT_MODE_ECB);

	        if(!$this->cekEmailIsExist($email)){
	        	$db = $this->getDB();
		        $db->fullname = $fullname;
		        $db->email = $email;
		        $db->password = sha1($password);
		        $db->active = 0;
		        
		        if($db->save()){
		        	$this->sendEmailToAdministrator($request);
	        		$this->writeToJSON(['add_user'=>true, 'fullname'=>$fullname, 'email'=>$email], 201);
		        } else{
	                $this->writeToJSON(['errmsg' => 'error save to database'], 500);
	            }
	        } else{
	        		$this->writeToJSON(['add_user'=>false, 'email_exist'=>true, 'email'=>$email], 201);
	        }
		} catch(\Exception $ex){
			$this->writeToJSON(['errmsg' => 'service unavailable'], 503);
		}
	}

	public function userActivation($userId){
		try{
			if($this->getDB()->isJuruKunci($this->app->request()->headers->get('API-Token'))){

				$getUser = $this->getDB()->where('id_auth', '=', $userId)->first()->toArray();
				$apiTokenAuth = new APITokenAuth($this->app);
				$token = $apiTokenAuth->createNewToken($getUser['email'], $getUser['password']);

	            $setUserToActive = $this->getDB()->find($userId);
	            $setUserToActive->active = 1;
	            $setUserToActive->token = $token;

	            if($setUserToActive->save()){
        			$this->writeToJSON(['active'=>true, 'user_id'=>$userId, 'token'=>$token], 201);
	            }
			} else {
				$this->writeToJSON(['errmsg'=>'dont have permission to active any users'], 500);
			}
		} catch(\Exception $ex){
			$this->writeToJSON(['errmsg' => 'service unavailable'], 503);
		}
	}

	public function cekEmailIsExist($email){
		$isExist = false;
		try{
			$isExist = $this->getDB()->query()->where('email', '=', $email)->get()->count();
			if($isExist > 1) {
				$isExist = true;
				$this->writeToJSON(['exist'=>true, 'email'=>$email], 201);
			} else {
				$this->writeToJSON(['exist'=>false, 'email'=>$email], 201);
			}
		} catch(\Exception $ex){
			$this->writeToJSON(['errmsg' => 'service unavailable'], 503);
		}
		return $isExist;
	}

	public function removeUser($userId){
		try{
			if($this->getDB()->isJuruKunci($this->app->request()->headers->get('API-Token'))){

	            $user = $this->getDB()->find($userId);

	            if($user->delete()){
        			$this->writeToJSON(['delete'=>true, 'user_id'=>$userId], 201);
	            }
			} else {
				$this->writeToJSON(['errmsg'=>'dont have permission to active any users'], 500);
			}
		} catch(\Exception $ex){
			$this->writeToJSON(['errmsg' => 'service unavailable'], 503);
		}
	}

	public function getAllPendingUser(){
		try{
			if($this->getDB()->isJuruKunci($this->app->request()->headers->get('API-Token'))){
				$users = $this->getDB()->query()->where('active', '=', 0)->get(['id_auth', 'fullname', 'email'])->toArray();
				if(count($users) > 0){
					$this->writeToJSON(['new_user'=> true, 'total_users'=>count($users),'users'=>$users], 201);
				} else{
					$this->writeToJSON(['new_user' => false], 201);
				}
			}
		} catch(\Exception $ex){
			$this->writeToJSON(['errmsg' => 'service unavailable'], 503);
		}
	}

	public function changePassword(){
		
	}

	public function viewUserActivity(){

	}

	private function sendEmailToAdministrator($request){
		return null;
	}

	private function safeHexToString($input){
	    if(strpos($input, '0x') === 0)
	    {
	        $input = substr($input, 2);
	    }
	    return hex2bin($input);
	}
}