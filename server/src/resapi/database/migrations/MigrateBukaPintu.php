<?php

namespace resapi\database\migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class MigrateBukaPintu {

    public function run(){
        Capsule::schema()->dropIfExists('buka_pintu');
        Capsule::schema()->create('buka_pintu', function($table){
            $table->increments('id_buka_pintu');
            $table->integer('id_auth')->unsigned();
            $table->foreign('id_auth')->references('id_auth')->on('api_auth')->onDelete('cascade');
            $table->integer('trigger_bel'); // 1 = nyalain bel || 0 = stop
            $table->timestamps();
        });
    }
}