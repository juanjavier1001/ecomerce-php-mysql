<?php

require_once "models/connection.php";

//recibimos los datos a travez del controlador y nos conectamos a la db , para hacer la consulta y volverle a devolver 

class ModelPost
{
    /*  */
    /* POST insert into en cualquier tabla  */
    /*  */

    static public function postData($table, $data)
    {


        $columns = "";
        $content = "";

        foreach ($data as $key => $value) {

            $columns .= $key . ",";
            $content .= ":$key" . ",";
        }


        $columns = rtrim($columns, ",");
        $content = rtrim($content, ",");


        try {

            //hacemos la conexion a la db  

            $pdo = Connection::connectDb();

            //creamos la consulta sql 

            //consulta a la que quiero llegar : 
            // INSERT INTO courses (title_course,description_course) values ("aprende ajedrez","Aprende las estrategias básicas del ajedrez y mejora tu habilidad en cada partida con este curso práctico y dinámico.") ;

            $sql = "INSERT INTO $table ($columns) values ($content) ";


            //preparo la consulta 

            $query = $pdo->prepare($sql);

            //despues de preparar la consulta bindeo 

            foreach ($data as $key => $value) {

                $query->bindParam(":$key", $data[$key], PDO::PARAM_STR);
            }

            //ejecuto 
            if ($query->execute()) {

                echo json_encode([
                    "status" => 200,
                    "result" => [
                        "message" => "Record inserted successfully",
                        "last_insert_id" => $pdo->lastInsertId()
                    ]
                ]);
            };
        } catch (PDOException $e) {

            $response = [
                "status" => 404,
                "result" => [
                    "message" => "Error en la consulta: " . $e->getMessage(),
                    "method" => "POST"
                ]
            ];

            echo json_encode($response, http_response_code($response["status"]));
        }
    }
}
