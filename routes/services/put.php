<?php

require_once "controllers/put.controller.php";

//recibimos por metodo http y lo pasamos al controlador 

if (isset($_GET["id"]) && isset($_GET["nameId"])) {

    //capturo los datos que obtengo del cuerpo de la solicitud , como si fuera un $_POST 
    $data = [];
    //convierto en un array asociativo , osea clave valor , con la clave definida 
    parse_str(file_get_contents("php://input"), $data);
    //verifico q lo que venga por el formulario no venga vacio
    if (!empty($data)) {
        PutController::putData($table, $data, $_GET["id"], $_GET["nameId"]);
    } else {
        $response = [

            "status" => 404,
            "result" => "Not Found Data Empty"

        ];
        echo json_encode($response, http_response_code($response["status"]));
    }
} else {
    $response = [

        "status" => 404,
        "result" => "Not Found"

    ];

    echo json_encode($response, http_response_code($response["status"]));
}
