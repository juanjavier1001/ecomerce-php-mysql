<?php
require_once "models/connection.php";


class ModelDelete
{

    static public function deleteData($table, $nameId, $id)
    {

        //consulta 
        //delete from courses where id_course = 49 ;

        try {
            //conexion a la db 
            $pdo = Connection::connectDb();

            //sql 

            $sql = "DELETE from $table WHERE  $nameId =  :$nameId ";


            //prepare 

            $query = $pdo->prepare($sql);

            //bindeo
            $query->bindParam(":$nameId", $id, PDO::PARAM_INT);

            //ejecuto 
            $query->execute();

            //verifico si las rows fueron afectadas 

            $rowCount = $query->rowCount();

            if ($rowCount > 0) {

                $response = [
                    "status" => 200,
                    "result" => [
                        "success" => true,
                        "message" => "register deleted successfully"
                    ]
                ];
            } else {
                $response = [
                    "status" => 404,
                    "success" => false,
                    "message" => "register not found",
                ];
            }
        } catch (PDOException $e) {

            $response = [
                "status" => 404,
                "result" => [
                    "success" => false,
                    "message" => $e->getMessage()
                ]
            ];
        }

        echo json_encode($response, http_response_code($response["status"]));
    }
}
