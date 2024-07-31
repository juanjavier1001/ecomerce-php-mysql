<?php



class Connection
{

    static public function infoDb()
    {

        $infoDb = [

            "database" => "db-apirest",
            "user" => "root",
            "pass" => ""
        ];

        return $infoDb;
    }

    static public function connectDb()
    {
        try {

            $pdo = new PDO(
                "mysql:host=localhost;dbname=" . Connection::infoDb()["database"],
                Connection::infoDb()["user"],
                Connection::infoDb()["pass"]
            );

            $pdo->exec("SET NAMES 'utf8'");
        } catch (PDOException $e) {

            die("Error de conexión: " . $e->getMessage());
        }

        return $pdo;
    }
}
