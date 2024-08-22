<?php

require_once "models/post.model.php";

//recibimos los datos a travez de la ruta y lo enviamos al modelo 

class PostController
{
    /*  */
    /* POST insert into en cualquier tabla  */
    /*  */
    static public function postData($table, $data)
    {

        ModelPost::postData($table, $data);
    }

    /*  */
    /* POST Registro de usuario  */
    /*  */
    static public function postRegister($table, $data, $suffix)
    {
        //si en data viene password e email y que los 2 no bengan vacios 
        if (isset($data["password_$suffix"]) && $data["password_$suffix"] != null && isset($data["email_$suffix"]) && $data["email_$suffix"] != null) {
            //encripto la password 
            $passHash = password_hash($data["password_$suffix"], PASSWORD_BCRYPT);
            //seteo el password que viene por $_POST
            $data["password_$suffix"] = $passHash;

            ModelPost::postData($table, $data);
        } else {

            $response = [
                "status" => 404,
                "result" => "data is missing"

            ];

            echo json_encode($response, http_response_code($response["status"]));
        }
    }
}
