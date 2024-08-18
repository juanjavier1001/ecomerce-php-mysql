<!-- recibo la solicitud enviada por las routes  -->
<!-- y las envio al modelo e invoco metodos del modelo -->
<!-- recibo la consulta enviada por el modelo y la muestro al cliente -->
<!-- creo otro metodo en esta clase para devolver lo q me trae la consulta en datos JSON -->
<?php

require_once "models/get.model.php";


class GetController
{

    /*  */
    /* controller sin filtro  */
    /*  */

    static public function getData($table, $select, $orderBy, $orderMode, $lmStart, $lmEnd)
    {

        $response = GetModel::getData($table, $select, $orderBy, $orderMode, $lmStart, $lmEnd);

        return GetController::fnResponse($response);
    }



    /*  */
    /* controller con filtro */
    /*  */
    static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $lmStart, $lmEnd)
    {
        $response = GetModel::getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $lmStart, $lmEnd);
        return GetController::fnResponse($response);
    }

    /*  */
    /* controller Relacion sin filtro */
    /*  */

    static public function getDataRel($select, $orderBy, $orderMode, $lmStart, $lmEnd, $rel, $type)
    {

        $response = GetModel::getDataRel($select, $orderBy, $orderMode, $lmStart, $lmEnd, $rel, $type);
        return GetController::fnResponse($response);
    }

    /*  */
    /* controller Relacion con filtro */
    /*  */

    static public function getDataRelFilter($select, $linkTo, $equalTo, $orderBy, $orderMode, $lmStart, $lmEnd, $rel, $type)
    {

        $response = GetModel::getDataRelFilter($select, $linkTo, $equalTo, $orderBy, $orderMode, $lmStart, $lmEnd, $rel, $type);
        return GetController::fnResponse($response);
    }

    /*  */
    /* controller  Busqueda sin relaciones (searchTo)*/
    /*  */


    static public function getDataSearch($table, $select, $linkTo, $searchTo, $orderBy, $orderMode, $lmStart, $lmEnd)
    {

        $response = GetModel::getDataSearch($table, $select, $linkTo, $searchTo, $orderBy, $orderMode, $lmStart, $lmEnd);
        return GetController::fnResponse($response);
    }

    /*  */
    /* controller  Busqueda con relaciones (searchTo)*/
    /*  */


    static public function getDataSearchRel($select, $linkTo, $searchTo, $orderBy, $orderMode, $lmStart, $lmEnd, $rel, $type)
    {
        $response = GetModel::getDataSearchRel($select, $linkTo, $searchTo, $orderBy, $orderMode, $lmStart, $lmEnd, $rel, $type);
        return GetController::fnResponse($response);
    }


    /*  */
    /* Respuesta del controller en formato JSON
    /*  */
    static public function fnResponse($response)
    {

        if (!empty($response)) {
            $json = [

                "status" => 200,
                "count" => count($response),
                "result" => $response
            ];
        } else {

            $json = [

                "status" => 404,
                "result" => "Not Found"
            ];
        }

        echo json_encode($json, http_response_code($json["status"]));
    }
}
