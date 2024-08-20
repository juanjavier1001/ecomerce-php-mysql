<?php

require_once "models/post.model.php";

//recibimos los datos a travez de la ruta y lo enviamos al modelo 

class PostController
{

    static public function postData($table, $data)
    {

        ModelPost::postData($table, $data);
    }
}
