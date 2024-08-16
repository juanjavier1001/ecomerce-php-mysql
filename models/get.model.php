<!-- el controlador llama a un metodo de este modelo para interactuar con la db  -->
<!-- devuelvo los datos de la consulta al controlador  -->
<!-- aca hago las consultas sql -->
<?php

require_once "connection.php";

//$pdo = Connection::connectDb();


class GetModel
{

    /*  */
    /* Model sin filtro */
    /*  */
    static public function getData($table, $select, $orderBy, $orderMode, $lmStart, $lmEnd)
    {

        try {
            //sin ninguno de los parametros 
            $sql = "SELECT $select FROM  $table";

            //si existe order by y ademas limit  
            if ($orderBy != null && $lmStart != null && $lmEnd != null) {

                $sql = "SELECT $select FROM $table ORDER BY $orderBy $orderMode limit $lmStart , $lmEnd";
            }

            //si existe order by SOLO
            else if ($orderBy != null) {

                $sql = "SELECT $select FROM  $table order by $orderBy $orderMode";
            }

            //si existe limit SOLO 
            else if ($lmStart != null && $lmEnd != null) {
                $sql = "SELECT $select FROM  $table limit $lmStart , $lmEnd";
            }



            //preparamos la consulta  

            $query = Connection::connectDb()->prepare($sql);

            $query->execute();

            //obtenemos los datos de la consulta como un array 

            return $query->fetchAll(PDO::FETCH_CLASS);
            //return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error general: ' . $e->getMessage();
        }
    }
    /*  */
    /* Model con filtro */
    /*  */

    static public function getDataFilter($table, $select, $linkTo, $equalTo, $orderBy, $orderMode, $lmStart, $lmEnd)
    {


        try {

            //$sql = "SELECT $select FROM $table WHERE $linkTo = :$linkTo ";

            //separo por coma lo que viene por $linkTo (id_course,image_course)
            $linkToArray = explode(",", $linkTo);

            //separo por coma lo que viene por $equalTo (1_python.jpg)
            $equalToArray = explode("_", $equalTo);

            //defino una varible vacia , y si en el parametro viene mas de 1 la modifico para que sea parte de la consulta (AND)
            $ArrayText = "";

            //Si $linkToArray tiene mas de un elemento , a este texto le agrego el AND y en la consulta este texto deja de estar vacio
            if (count($linkToArray) > 1) {

                //entonces recorro $linkToArray para modificar la consulta 
                foreach ($linkToArray as $key => $value) {

                    //hago que empiece del segundo parametro recibido , osea que evite el primer parametro
                    if ($key > 0) {
                        $ArrayText .= "AND " . $value . " = " . ":$value" . " ";
                    }
                }
            }

            //consulta a la que quiero llegar ;
            //select * from courses where id_course = 1  AND image_course = "python.jpg" ;


            //Si $linkToArray tiene mas de un elemento , a este texto le agrego el AND y en la consulta este texto deja de esta vacio

            $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $ArrayText";


            //si existe order by y ademas limit  
            if ($orderBy != null && $lmStart != null && $lmEnd != null) {

                $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $ArrayText ORDER BY $orderBy $orderMode LIMIT $lmStart , $lmEnd";
            }

            //si existe order by SOLO
            else if ($orderBy != null) {

                $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $ArrayText ORDER BY $orderBy $orderMode";
            }

            //si existe limit SOLO 
            else if ($lmStart != null && $lmEnd != null) {

                $sql = "SELECT $select FROM $table WHERE $linkToArray[0] = :$linkToArray[0] $ArrayText LIMIT $lmStart , $lmEnd";
            }



            /* CODIGO JC PREGUNTAMOS SI VIENE LIKE , SI VIENE MODIFICAMOS LA CONSULTA SACANDO EL IGUAL =  */

            /*  if (strpos($equalToArray[0], 'like') !== false) {
                $sql = "SELECT $select FROM $table WHERE $linkToArray[0] like 'c%' $ArrayText";
            } */

            //echo $sql;

            //die();

            /* CODIGO JC PREGUNTAMOS SI VIENE LIKE , SI VIENE MODIFICAMOS LA CONSULTA SACANDO EL IGUAL =  */

            //preparamos la consulta
            $query = Connection::connectDb()->prepare($sql);

            //despues de preparar la consulta lo bindeo 
            //recorremos el array para bindear 

            foreach ($linkToArray as $key => $value) {

                $query->bindParam(":$value", $equalToArray[$key], PDO::PARAM_STR);
                //$query->bindParam(":$linkToArray[$key]", $equalToArray[$key], PDO::PARAM_STR);
            }

            $query->execute();

            //obtenemos los datos de la consulta como un array 

            return $query->fetchAll(PDO::FETCH_CLASS);
            //return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error general: ' . $e->getMessage();
        }
    }

    /*  */
    /* Model Relation sin filtro */
    /*  */
    static public function getDataRel($select, $orderBy, $orderMode, $lmStart, $lmEnd, $rel, $type)
    {

        try {
            $ArrayRel = explode(",", $rel);
            $ArrayType = explode(",", $type);
            $ArrayRelText = "";


            //consulta que quiero llegar : SELECT * FROM courses inner join instructors on courses.id_instructor_course = instructors.id_instructor
            //consulta dinamica : sumarle otro inner join por cada elemento del $ArrayRel 
            //sin ninguno de los parametros 

            //preguntamos si viene mas de un dato en $ArrayRel

            if (count($ArrayRel) > 1) {


                foreach ($ArrayRel as $key => $value) {

                    //comience desde el indice 1 , osea el 2 elemento 
                    if ($key > 0) {

                        $ArrayRelText .= "INNER JOIN " . $ArrayRel[$key] . " on " . "$ArrayRel[0].id_$ArrayType[$key]_$ArrayType[0] = " . " $ArrayRel[$key].id_$ArrayType[$key]" . " ";
                    }
                }


                $sql = "SELECT $select FROM $ArrayRel[0] $ArrayRelText";


                /* $sql = "SELECT $select FROM $ArrayRel[0] INNER JOIN $ArrayRel[1] on $ArrayRel[0].id_$ArrayType[1]_$ArrayType[0] = $ArrayRel[1].id_$ArrayType[1]"; */


                //si existe order by y ademas limit  
                if ($orderBy != null && $lmStart != null && $lmEnd != null) {

                    $sql = "SELECT $select FROM $ArrayRel[0] $ArrayRelText ORDER BY $orderBy $orderMode limit $lmStart , $lmEnd";
                }

                //si existe order by SOLO
                else if ($orderBy != null) {

                    $sql = "SELECT $select FROM  $ArrayRel[0] $ArrayRelText order by $orderBy $orderMode";
                }

                //si existe limit SOLO 
                else if ($lmStart != null && $lmEnd != null) {
                    $sql = "SELECT $select FROM  $ArrayRel[0] $ArrayRelText limit $lmStart , $lmEnd";
                }



                //preparamos la consulta  

                $query = Connection::connectDb()->prepare($sql);

                $query->execute();

                //obtenemos los datos de la consulta como un array 

                return $query->fetchAll(PDO::FETCH_CLASS);
            } else {

                return null;
            }
            //return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error general: ' . $e->getMessage();
        }
    }
    /*  */
    /* Model Relation con filtro */
    /*  */
    static public function getDataRelFilter($select, $linkTo, $equalTo, $orderBy, $orderMode, $lmStart, $lmEnd, $rel, $type)
    {

        try {

            //separo por coma lo que viene por $equalTo (id_instructor,image_course)
            $linkToArray = explode(",", $linkTo);
            //separo por coma lo que viene por $equalTo (1_python.jpg)
            $equalToArray = explode("_", $equalTo);
            //defino una varible vacia , y si en el parametro viene mas de 1 la modifico para que sea parte de la consulta (AND)
            $ArrayTextWhere = "";

            // preguntamos si $linkToArray tiene mas de 1 elemento 

            if (count($linkToArray) > 1) {

                foreach ($linkToArray as $key => $value) {

                    //empiece a partir del 2do elemento [0 id_instructor] [1 image_course]
                    //AND image_course =  "python.jpg"
                    if ($key > 0) {

                        $ArrayTextWhere .= "AND " . $value . " =  :$value" . " ";
                    }
                }
            }


            $ArrayRel = explode(",", $rel);
            $ArrayType = explode(",", $type);
            $ArrayRelTextFilter = "";


            //CONSULTA ESTATICA
            //consulta que quiero llegar : select * from courses  inner join instructors on courses.id_instructor_course = instructors.id_instructor where id_instructor_course = 1  ; 

            //CONSULTA DINAMICA 
            //select * from courses  inner join instructors on courses.id_instructor_course = instructors.id_instructor where id_instructor_course = 1 AND image_course =  "python.jpg" ; 
            //consulta dinamica : sumarle otro inner join por cada elemento del $ArrayRel 
            //sin ninguno de los parametros 

            //preguntamos si viene mas de un dato en $ArrayRel

            if (count($ArrayRel) > 1) {


                foreach ($ArrayRel as $key => $value) {

                    //comience desde el indice 1 , osea el 2 elemento 
                    if ($key > 0) {

                        $ArrayRelTextFilter .= "INNER JOIN " . $ArrayRel[$key] . " on " . "$ArrayRel[0].id_$ArrayType[$key]_$ArrayType[0] = " . " $ArrayRel[$key].id_$ArrayType[$key]" . " ";
                    }
                }



                $sql = "SELECT $select FROM $ArrayRel[0] $ArrayRelTextFilter Where $linkToArray[0] = :$linkToArray[0] $ArrayTextWhere ";


                //si existe order by y ademas limit  
                if ($orderBy != null && $lmStart != null && $lmEnd != null) {

                    $sql = "SELECT $select FROM $ArrayRel[0] $ArrayRelTextFilter WHERE $linkToArray[0] = :$linkToArray[0] $ArrayTextWhere ORDER BY $orderBy $orderMode LIMIT $lmStart , $lmEnd";
                }

                //si existe order by SOLO
                else if ($orderBy != null) {

                    $sql = "SELECT $select FROM $ArrayRel[0] $ArrayRelTextFilter WHERE $linkToArray[0] = :$linkToArray[0] $ArrayTextWhere ORDER BY $orderBy $orderMode";
                }

                //si existe limit SOLO 
                else if ($lmStart != null && $lmEnd != null) {

                    $sql = " SELECT $select FROM $ArrayRel[0] $ArrayRelTextFilter WHERE $linkToArray[0] = :$linkToArray[0] $ArrayTextWhere LIMIT $lmStart , $lmEnd";
                }


                //preparamos la consulta  

                $query = Connection::connectDb()->prepare($sql);

                //bindeamos los datos 

                foreach ($linkToArray as $key => $value) {

                    $query->bindParam(":$value", $equalToArray[$key], PDO::PARAM_STR);
                }


                $query->execute();

                //obtenemos los datos de la consulta como un array 

                return $query->fetchAll(PDO::FETCH_CLASS);
            } else {

                return null;
            }
            //return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo 'Error general: ' . $e->getMessage();
        }
    }
}
