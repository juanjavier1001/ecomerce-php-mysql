<?php

require_once "controllers/get.controllers.php";

//$arrayUrl es lo que viene despues del dominio /products 

//$table(/course) esto le tengo que pasar al controlador , para saber a que tabla hacer las consultas 
$table = $arrayUrl[1];

//me tome el primer elemento del array osea lo que este antes del ?
$table = explode("?", $table)[0];


//si $_GET trae algo (osea recibimos un parametro select) , que $select sea ese valor , sino por defecto "*"

$select = $_GET["select"] ?? "*";


/* ******************* */
/* consulta con filtro */
/* ******************* */

if (isset($_GET["linkTo"]) && isset($_GET["equalTo"])) {

    $linkTo = $_GET["linkTo"];
    $equalTo = $_GET["equalTo"];

    /*  $array = [
        $table,
        $select,
        $linkTo,
        $equalTo
    ];

    $sql = "SELECT $select FROM $table WHERE $linkTo = $equalTo ";

    var_dump($sql);

    die(); */

    GetController::getDataFilter($table, $select, $linkTo, $equalTo);
} else {
    /* ******************* */
    /* consulta sin filtro */
    /* ******************* */

    GetController::getData($table, $select);
}
