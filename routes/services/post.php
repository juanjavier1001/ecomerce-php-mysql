<?php

require_once "controllers/post.controllers.php";


//recibimos la solicitud http y la enviamos al controlador 

//preguntamos si viene algo por $_POST 

if (isset($_POST)) {

    //mandamos los datos de POST al controlador 

    PostController::postData($table, $_POST);
}
