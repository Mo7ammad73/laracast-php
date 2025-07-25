<?php
    class Database {
        public $connection;
        public function __construct($config , $username="root", $password="")
        {
            try {
                $dsn = "mysql:" . http_build_query($config, "", ";");
                $this->connection = new PDO($dsn, $username, $password);
            }
            catch (PDOException $e) {
                echo "خطا در اتصال :" . $e->getMessage();
            }
        }
        public function query($query , $params = [])
        {
            try {
                $statement = $this->connection->prepare($query);
                $statement->execute($params);
                return $statement;
            }
            catch (Exception $e) {
                echo "خطا در اجرای دستورات query" . $e->getMessage();
            }
        }

    }