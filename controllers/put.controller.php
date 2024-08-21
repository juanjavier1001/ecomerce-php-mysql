<?php

require_once "models/put.model.php";

//le paso al modelo 
class PutController
{


    static public function putData($table, $data, $id, $nameId)
    {
        ModelPut::putData($table, $data, $id, $nameId);
    }
}
