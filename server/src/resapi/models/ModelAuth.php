<?php

namespace resapi\models;

use Illuminate\Database\Eloquent\Model as Model;

class ModelAuth extends Model{

    protected $table = 'api_auth';
    protected $primaryKey = 'id_auth';

    /**
     * setup relationship between data_customer 1 .... * data_customer_items
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function infoBukaPintu(){
        return $this->hasMany('\resapi\models\ModelBukaPintu');
    }

    public function getIdAuthByToken($token){
    	$values = $this->where('token', '=', $token)->first()->toArray();
    	return $values['id_auth'];
    }

    public function isJuruKunci($token){
        $id = $this->getIdAuthByToken($token);
        if($id == 1){
            return true;
        }
        return false;
    }
} 