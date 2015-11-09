<?php
/*******************************************************
 * Copyright (C) 2015 Muhammad Juan Akbar - All Rights Reserved
 * Written by Muhammad Juan Akbar <mail@mjuanakbar.info>, 07 2015
 *
 * APIKeyManager.php can not be copied and/or distributed without the express
 * permission of author.
 *******************************************************/

namespace resapi\libraries;

use resapi\models\ModelAuth;
use Rhumsaa\Uuid\Uuid;

class APITokenAuth extends Base{

    /**
     * get database connection
     * @return ModelAuth
     */
    private function getDB(){
        return new ModelAuth();
    }

    /**
     * generate new api of exists user
     * body request => JSON
     *{'email':'email', 'password':'password'}
     */
    public function createNewToken($email=null, $password=null){
        $request = json_decode($this->request->getBody());

        if(empty($email) || empty($password)) {
            $email = isset($request->email) ? filter_var($request->email, FILTER_SANITIZE_STRING) : false;
            $password = isset($request->password) ? sha1(filter_var($request->password, FILTER_SANITIZE_STRING)) : false;
        }

        if (!$email || !$password) {
            $this->writeToJson(['errmsg' => 'parameter missing'], 400);
            return;
        }

        if(!$this->isUserValid($email, $password)){
            $this->writeToJson(['errmsg' => 'email/password not found'], 400);
            return;
        }

        $token = $this->generateUUID($email."/".$password);

        try{
            $arrId = $this->getDB()->query()->where('email', '=', $email)
                ->where('password', '=', $password)
                ->get(['id_auth'])->toArray();

            $id = $arrId[0]['id_auth'];
            $wantAddAPI = $this->getDB()->find($id);
            $wantAddAPI->token = $token;

            if($wantAddAPI->save()){
                $this->writeToJson(["message" => "key telah berhasil dibuat", "email" => $email, "api key" => $token, 201]);
            } else{
                $this->writeToJSON(['errmsg' => 'error save to database'], 500);
            }
        } catch(\Exception $e){
            $this->writeToJSON(['errmsg' => 'service unavailable'], 503);
        }
        return $token;
    }

    /**
     * check if API-Key and WWW-Authorization valid
     * @param $token
     * @param $authentication
     * @return bool
     */
    public function isApiKeyUserPassValid($token, $authentication){
        try{
            if(Uuid::isValid($token)){
                $check = $this->getDB()->query()->where('email', '=', base64_decode($authentication))
                    ->where('token', '=', $token)
                    ->get()->count();
                if(!$check){
                    return false;
                }
                return true;
            }
        } catch(\Exception $e){
            $this->writeToJSON(['errmsg' => 'service unavailable'], 503);
        }
        return false;
    }

    /**
     * check if user valid or not
     * by email & password
     * @param $email
     * @param $password
     * @return bool
     */
    private function isUserValid($email, $password){
        $check = $this->getDB()->query()->where('email', '=', $email)
            ->where('password', '=', $password)
            ->get()->count();
        if($check){
            return true;
        }
        return false;
    }

    /**
     * generate random api-key
     * @param $mixed
     * @return string
     */
    private function generateUUID($mixed){
        return Uuid::uuid5(Uuid::uuid4(), $mixed)->toString();
    }

    public function getIdAuthByToken($token){
        try{
            echo "<pre>";var_dump($token); die();
            $tes = $this->getDB()->query()->where('token', '=', $token)->get()->count();
        } catch(\Exception $ex){
            $this->writeToJSON(['errmsg' => 'service unavailable'], 503);
        }
    }
} 