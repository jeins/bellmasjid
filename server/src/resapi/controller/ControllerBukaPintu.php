<?php

namespace resapi\controller;

use resapi\libraries\Base;
use resapi\models\ModelBukaPintu;
use resapi\models\ModelAuth;

class ControllerBukaPintu extends Base {

	private function getDB(){
		return new ModelBukaPintu();
	}

	public function bukaPintu(){
		try{
			$dbAuth = new ModelAuth();
			$id_auth = $dbAuth->getIdAuthByToken($this->app->request()->headers->get('API-Token'));

			$db = $this->getDB();
			$db->id_auth = $id_auth;
			$db->trigger_bel = 1;
			$db->save();

            $this->writeToJSON(['pintu_buka' => true, 'user' => $id_auth], 201);
		} catch(\Exception $ex){
			$this->writeToJSON(['errmsg' => 'service unavailable'], 503);
		}
	}

	public function stopBukaPintu(){
		try{
			$saveFile = $this->getDB()->query()->where('trigger_bel', '=', 1)->update(['trigger_bel' => 0]);
            if($saveFile){
                $this->writeToJSON(['trigger_bel' => 0, 'stop_buka_pintu' => true]);
            } else{
                $this->writeToJSON(['errmsg' => 'not found'], 204);
            }
		} catch(\Exception $ex){
			$this->writeToJSON(['errmsg' => 'service unavailable'], 503);
		}
	}
}