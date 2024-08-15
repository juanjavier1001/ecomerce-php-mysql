<?php

require_once "controllers/get.controllers.php";

//$arrayUrl es lo que viene despues del dominio /products 

//$table(/course) esto le tengo que pasar al controlador , para saber a que tabla hacer las consultas 
$table = $arrayUrl[1];

//me tome el primer elemento del array osea lo que este antes del ?
$table = explode("?", $table)[0];


//si $_GET trae algo (osea recibimos un parametro select) , que $select sea ese valor , sino por defecto "*"

$select = $_GET["select"] ?? "*";
$orderBy = $_GET["orderBy"] ?? null;
$orderMode = $_GET["orderMode"] ?? "ASC";
$lmStart = $_GET["lmStart"] ?? null;
$lmEnd = $_GET["lmEnd"] ?? null;



//consulta seria : order by columna orderMode  

/* ******************* */
/* consulta con filtro */
/* ******************* */

if (isset($_GET["linkTo"]) && isset($_GET["equalTo"])) {

    $linkTo = $_GET["linkTo"];
    $equalTo = $_GET["equalTo"];


    GetController::getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $lmStart, $lmEnd);
} else {
    /* ******************* */
    /* consulta sin filtro */
    /* ******************* */

    GetController::getData($table, $select, $orderBy, $orderMode, $lmStart, $lmEnd);
}
