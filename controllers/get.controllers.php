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

    static public function getData($table, $select)
    {

        $response = GetModel::getData($table, $select);

        return GetController::fnResponse($response);
    }



    /*  */
    /* controller con filtro */
    /*  */
    static public function getDataFilter($table, $select, $linkTo, $equalTo)
    {

        $response = GetModel::getDataFilter($table, $select, $linkTo, $equalTo);
        GetController::fnResponse($response);
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
