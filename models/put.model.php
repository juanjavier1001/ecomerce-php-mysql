<?php

require_once "models/connection.php";

//recibo del controller y me conecto con la db para hacer la consulta
class ModelPut
{

    static public function putData($table, $data, $id, $nameId)
    {

        //consulta a la que quiero llegar : 
        //UPDATE courses SET price_course = 10 WHERE id_course = 2;

        //UPDATE courses SET price = :price,description = :description WHERE course_id = :course_id;

        try {


            //devulevo la conexion 
            $pdo = Connection::connectDb();

            $column = "";

            foreach ($data as $key => $value) {

                $column .= $key . " = " . " :$key " . ",";
            }

            //elimino la ultima coma 
            $column = rtrim($column, ",");


            $sql = "UPDATE $table  SET $column WHERE $nameId = $id ";


            //preparo la consulta 

            $query = $pdo->prepare($sql);

            //bindeo los datos 

            foreach ($data as $key => $value) {

                $query->bindParam(":$key", $data[$key], PDO::PARAM_STR);
            }

            //ejecuto 

            $query->execute();

            // Obtiene el número de filas afectadas
            $rowCount = $query->rowCount();

            if ($rowCount > 0) {
                $response = [
                    "status" => 200,
                    "result" => [
                        "message" => "Record updated successfully"
                    ]
                ];
            } else {
                // Si no se afectaron filas, puede significar que no hubo cambios
                $response =
                    [
                        "status" => 200,
                        'success' => false,
                        'message' => 'No se realizaron cambios. Es posible que el curso no exista o que los datos sean los mismos.',
                        'rows_affected' => 0
                    ];
            }
        } catch (PDOException $e) {

            $response = [

                "status" => 404,
                "result" => [
                    "message" => "Error en la consulta: " . $e->getMessage(),
                    "method" => "PUT"
                ]

            ];
        }

        echo json_encode($response, http_response_code($response["status"]));
    }
}
