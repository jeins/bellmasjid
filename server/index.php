<?php
 /*******************************************************
 * Copyright (C) 2015 Muhammad Juan Akbar - All Rights Reserved
 * Written by Muhammad Juan Akbar <mail@mjuanakbar.info>, 07 2015
 *
 * index.php can not be copied and/or distributed without the express
 * permission of author.
 *******************************************************/

namespace resapi;

require 'vendor/autoload.php';

$app = new Setup();
$app->run();
$res = $app->response();
$res->header('Access-Control-Allow-Origin', '*');
$res->header("Access-Control-Allow-Methods: PUT, GET, POST, DELETE, OPTIONS");
$res->header("Access-Control-Allow-Headers: api-token, www-authorization");