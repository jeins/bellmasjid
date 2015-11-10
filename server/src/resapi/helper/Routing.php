<?php
 /*******************************************************
 * Copyright (C) 2015 Muhammad Juan Akbar - All Rights Reserved
 * Written by Muhammad Juan Akbar <mail@mjuanakbar.info>, 07 2015
 *
 * Routing.php can not be copied and/or distributed without the express
 * permission of author.
 *******************************************************/

namespace resapi\helper;

use resapi\controller\ExpControllerDataCustomer;
use resapi\controller\ControllerBukaPintu;
use resapi\controller\ControllerAuth;
use resapi\libraries\APITokenAuth;
use resapi\Setup;

class Routing {

    /**
     * Setup routing request
     * @param Setup $app
     */
    public static function setupRouting(Setup $app){
        $app->group(
            '/v1',
            function() use($app){
                // CREATE API KEY
                $app->post('/create-api-token', function() use($app){
                    $token = new APITokenAuth($app);
                    $token->createNewToken();
                });

                // ControllerBukaPintu
                $ctrlBukaPintu = new ControllerBukaPintu($app);

                ### GET
                $app->get('/bukapintu', 
                    function() use($ctrlBukaPintu){
                        $ctrlBukaPintu->bukaPintu();
                    }
                );

                $app->get('/stopbukapintu', 
                    function() use($ctrlBukaPintu){
                        $ctrlBukaPintu->stopBukaPintu();
                    }
                );

                // ControllerAuth
                $ctrlAuth = new ControllerAuth($app);

                ### POST
                $app->post('/login',
                    function() use($ctrlAuth){
                        $ctrlAuth->loginToGetToken();
                    }
                );

                $app->post('/register',
                    function() use($ctrlAuth){
                        $ctrlAuth->registerNewUser();
                    }
                );

                ### GET
                $app->get('/active/:USER_ID',
                    function($USER_ID) use($ctrlAuth){
                        $ctrlAuth->userActivation($USER_ID);
                    }
                );

                $app->get('/isexist/:EMAIL',
                    function($EMAIL) use($ctrlAuth){
                        $ctrlAuth->cekEmailIsExist($EMAIL);
                    }
                );

                $app->get('/pending-users',
                    function() use($ctrlAuth){
                        $ctrlAuth->getAllPendingUser();
                    }
                );

                ### DELETE
                $app->delete('/user/:USER_ID',
                    function($USER_ID) use($ctrlAuth){
                        $ctrlAuth->removeUser($USER_ID);
                    }
                );
            }
        );
    }
}