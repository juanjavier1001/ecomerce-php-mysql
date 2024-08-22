<?php

require_once "controllers/post.controllers.php";


//recibimos la solicitud http y la enviamos al controlador 

//preguntamos si viene algo por $_POST 

if (isset($_POST)) {

    if (!empty($_POST)) {

        /*  */
        /* POST Registro de usuario  */
        /*  */
        if (isset($_GET["register"]) && $_GET["register"] == true) {

            $suffix = $_GET["suffix"] ?? "user";

            PostController::postRegister($table, $_POST, $suffix);
        } else {

            /*  */
            /* POST insert into en cualquier tabla  */
            /*  */
            PostController::postData($table, $_POST);
        }
    } else {

        $response = [

            "status" => 404,
            "result" => "Not Found"

        ];

        echo json_encode($response, http_response_code($response["status"]));
    }
}
