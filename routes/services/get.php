<?php

require_once "controllers/get.controllers.php";

//$arrayUrl es lo que viene despues del dominio /products 

//$table(/course) esto le tengo que pasar al controlador , para saber a que tabla hacer las consultas 
$table = $arrayUrl[1];

//si le pasamos un parametro que siga tomando lo que esta dsp del dominio y antes del param : /courses?param1 , toma :course por $table[0]
$table = explode("?", $table)[0];


//si $_GET trae algo (osea recibimos un parametro select) , que $select sea ese valor , sino por defecto "*"

$select = $_GET["select"] ?? "*";
$orderBy = $_GET["orderBy"] ?? null;
$orderMode = $_GET["orderMode"] ?? "ASC";
$lmStart = $_GET["lmStart"] ?? null;
$lmEnd = $_GET["lmEnd"] ?? null;
$rel = $_GET["rel"] ?? null;
$type = $_GET["type"] ?? null;
$linkTo = $_GET["linkTo"] ?? null;
$equalTo = $_GET["equalTo"] ?? null;
$searchTo = $_GET["searchTo"] ?? null;



/* ******************* */
/* consulta con Search con relaciones */
/* ******************* */
if (isset($rel) && isset($type) && isset($linkTo) && isset($searchTo) && $table === "relations") {

    GetController::getDataSearchRel($select, $linkTo, $searchTo, $orderBy, $orderMode, $lmStart, $lmEnd, $rel, $type);


    /* ******************* */
    /* consulta con Search sin relaciones */
    /* ******************* */
} else if (isset($linkTo) && isset($searchTo)) {

    //select * from courses where description_course like "%do%"; 

    GetController::getDataSearch($table, $select, $linkTo, $searchTo, $orderBy, $orderMode, $lmStart, $lmEnd);
    /* ******************* */
    /* consulta con relacion con filtro  */
    /* ******************* */
} else if (isset($linkTo) && isset($equalTo) && isset($rel) && isset($type) && $table === "relations") {

    GetController::getDataRelFilter($select, $linkTo, $equalTo, $orderBy, $orderMode, $lmStart, $lmEnd, $rel, $type);
}

/* ******************* */
/* consulta con relacion sin filtro  */
/* ******************* */

//consuta :  select * from courses inner join instructors on courses.id_instructor_course = instructors.id_instructor
//?rel=courses,instructor . busque relacion entre las tablas courses e instructor  
//&type=course,instructor . busque coincidencias con los nombres de las columnas en singular 
//transformada  select * from  $arrayRel[0]  inner join $arrayrel[1] on $arrayRel[0].id_$type[0]_course = $arrayRel[1].id_$type[1];    
else if (isset($rel) && isset($type) && $table === "relations") {

    GetController::getDataRel($select, $orderBy, $orderMode, $lmStart, $lmEnd, $rel, $type);
    /* ******************* */
    /* consulta con filtro */
    /* ******************* */
} else if (isset($linkTo) && isset($equalTo)) {

    GetController::getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $lmStart, $lmEnd);
} else {
    /* ******************* */
    /* consulta sin filtro */
    /* ******************* */

    GetController::getData($table, $select, $orderBy, $orderMode, $lmStart, $lmEnd);
}
