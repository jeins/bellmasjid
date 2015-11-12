<?php

namespace resapi\controller;

use resapi\libraries\Base;
use resapi\models\ModelBukaPintu;
use resapi\models\ModelAuth;
use resapi\libraries\Config;

class ControllerBukaPintu extends Base {

	private function getDB(){
		return new ModelBukaPintu();
	}

	public function bukaPintu(){
		try{
			$dbAuth = new ModelAuth();
			$id_auth = $dbAuth->getIdAuthByToken($this->app->request()->headers->get('API-Token'));
			$this->sendTrigger($id_auth, 1);
			sleep(5);
			$this->sendTrigger($id_auth, 0);
		} catch(\Exception $ex){
			$this->writeToJSON(['errmsg' => 'service unavailable'], 503);
		}
	}

	private function sendTrigger($id_auth, $val){
		$sendTriggerOpen = file_put_contents(Config::BUKA_PINTU_PATH, $val);
		if($sendTriggerOpen){
			$db = $this->getDB();
			$db->id_auth = $id_auth;
			$db->trigger_bel = $val;
			$db->save();

			if($val){
				$this->writeToJSON(['pintu_buka' => true, 'user' => $id_auth], 201);
			} else {
				$this->writeToJSON(['pintu_buka' => false, 'user' => $id_auth], 201);
			}
		} else {
			$this->writeToJSON(['errmsg' => 'error send trigger buka pintu', 'pintu_buka'=> false, 'user' => $id_auth], 201);
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