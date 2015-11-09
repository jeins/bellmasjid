<?php

namespace resapi\database\seeds;

use resapi\models\ModelAuth;

class SeedAuth {

    public function run(){
        foreach($this->data() as $data){
            $db = new ModelAuth();
            foreach($data as $key=>$value){
                $db->$key = $value;
            }
            $db->save();
        }
    }

    private function data(){
        return [
            [
                'fullname'  => 'Juru Kunci IWKZ',
                'email'     => 'bid1@iwkz.de', # YmlkMUBpd2t6LmRl
                'password'  => sha1('bid11WK2'), # jgn lupa dirubah! / 0x4aaa052ff8276beb
                'token'     => 'a7fa5751-12c1-5150-b668-98ceede7af0b',
                'active'    => 1
            ],
            [
                'fullname'  => '###',
                'email'     => 'heinz.schneider@abc.com',
                'password'  => sha1('12341ACVA'),
                'token'     => '',
                'active'    => 0
            ],
            [
                'fullname'  => '###',
                'email'  => 'buerojenderko@abc.com',
                'password'  => sha1('AQWEOAmyxf!'),
                'token'     => '',
                'active'    => 0
            ],
            [
                'fullname'  => '###',
                'email'  => 'lemke@abc.com',
                'password'  => sha1('Powlqd.-!123'),
                'token'     => '',
                'active'    => 0
            ],
            [
                'fullname'  => '###',
                'email'  => 'e10@abc.com',
                'password'  => sha1('Ma123jasdu13'),
                'token'     => '',
                'active'    => 0
            ],
            [
                'fullname'  => '###',
                'email'  => 'jenderko@abc.com',
                'password'  => sha1('M123as1!.'),
                'token'     => '',
                'active'    => 0
            ],
            [
                'fullname'  => '###',
                'email'  => 'sudiman@abc.com',
                'password'  => sha1('941Ksd128!..'),
                'token'     => '',
                'active'    => 0
            ],
            [
                'fullname'  => '###',
                'email'  => 'santosa@abc.com',
                'password'  => sha1('..9123sdk!jdd'),
                'token'     => '',
                'active'    => 0
            ],
            [
                'fullname'  => '###',
                'email'  => 'andrean.john@abc.com',
                'password'  => sha1('Laksdiqj!asd.'),
                'token'     => '',
                'active'    => 0
            ],
            [
                'fullname'  => '###',
                'email'  => 'jalanraya@abc.com',
                'password'  => sha1('-,and12j3!'),
                'token'     => '',
                'active'    => 0
            ]
        ];
    }
} 