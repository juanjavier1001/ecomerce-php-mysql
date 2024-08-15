<?php

//url obtenida //todo lo que viene despues del dominio (/course)
$urlServer = $_SERVER["REQUEST_URI"];


//convierto en un array separando por / ([0]/[1]course )
$arrayUrl = explode("/", $urlServer);


//elimino los elementos vacios ([1] course)
$arrayUrl = array_filter($arrayUrl);


if (empty($arrayUrl)) {

    $json = [

        "status" => 404,
        "result" => "Not Found"

    ];

    echo json_encode($json, http_response_code($json["status"]));

    return;
}


if (count($arrayUrl) == 1 && isset($_SERVER["REQUEST_METHOD"])) {



    /* METHOD GET */


    if ($_SERVER["REQUEST_METHOD"] === "GET") {

        include "services/get.php";
    }


    /* METHOD POST */


    if ($_SERVER["REQUEST_METHOD"] === "POST") {


        $json = [

            "status" => 200,
            "result" => "POST"

        ];

        echo json_encode($json, http_response_code($json["status"]));
        return;
    }
    /* METHOD PUT */


    if ($_SERVER["REQUEST_METHOD"] === "PUT") {


        $json = [

            "status" => 200,
            "result" => "PUT"

        ];

        echo json_encode($json, http_response_code($json["status"]));
        return;
    }
    /* METHOD DELETE */


    if ($_SERVER["REQUEST_METHOD"] === "DELETE") {


        $json = [

            "status" => 200,
            "result" => "DELETE"

        ];

        echo json_encode($json, http_response_code($json["status"]));
        return;
    }
} else {

    $json = [

        "status" => 404,
        "result" => "Not Found"

    ];

    echo json_encode($json, http_response_code($json["status"]));
}
