<?php

require_once "controllers/delete.controller.php";


if (isset($_GET["id"]) && isset($_GET["nameId"])) {


    DeleteController::deleteData($table, $_GET["nameId"], $_GET["id"]);
} else {

    $response = [
        "status" => 404,
        "messg" => "NOT FOUND"

    ];

    echo json_encode($response, http_response_code($response["status"]));
}
