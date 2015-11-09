<?php

namespace resapi\models;

use Illuminate\Database\Eloquent\Model as Model;

class ModelBukaPintu extends Model{

    protected $table = 'buka_pintu';
    protected $primaryKey = 'id_buka_pintu';

    /**
     * setup relationship between data_customer 1 .... * data_customer_items
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function infoAuth(){
        return $this->belongsTo('\resapi\models\ModelAuth');
    }
}