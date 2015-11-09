<?php

namespace resapi\database\migrations;

use Illuminate\Database\Capsule\Manager as Capsule;

class MigrateAuth {

    public function run(){
        Capsule::schema()->dropIfExists('buka_pintu'); ## remove child first

        Capsule::schema()->dropIfExists('api_auth');
        Capsule::schema()->create('api_auth', function($table){
            $table->increments('id_auth');
            $table->string('fullname');
            $table->string('email');
            $table->string('password');
            $table->string('token');
            $table->integer('active');
            $table->timestamps();
        });
    }
} 