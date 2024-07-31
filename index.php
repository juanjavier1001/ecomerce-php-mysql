<?php
require_once "models/connection.php";
require_once "controllers/routes.controller.php";

$index = new RoutesControllers();

$index->index();


$cn = Connection::connectDb();
var_dump($cn);












//var_dump($arrayUrl);



/* $nombres = "jj,jj1,jj2";

$nombresExp = explode(",", $nombres);

echo $nombres;

var_dump($nombresExp); */



/* $url = "/javier";

$urlExp = explode("/", $url);

var_dump($urlExp);
 */