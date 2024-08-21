<?php

require_once "models/delete.model.php";

class DeleteController
{


    static public function deleteData($table, $nameId, $id)
    {
        ModelDelete::deleteData($table, $nameId, $id);
    }
}
