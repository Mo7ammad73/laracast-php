<?php
    class Database {
        public $connection;
        public $statement;
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
                $this->statement = $this->connection->prepare($query);
                $this->statement->execute($params);
                return $this;
            }
            catch (Exception $e) {
                echo "خطا در اجرای دستورات query" . $e->getMessage();
            }
        }
        public function fetch(){
            return $this->statement->fetch();
        }
        public function get(){
            return $this->statement->fetchAll();
        }
        public function findOrFail() {
            $result = $this->statement->fetch();
            if (! $result) {
                http_response_code(404);
                header("Location:/laracast-php/controller/404.php");
                exit();
            }
            return $result;
        }





    }