<?php

class Database
{
    public $connection;

    public function __construct()
    {
        $dsn = "mysql:host=127.0.0.1;port=3306;dbname=myapp;user=root;password=db_password;charset=utf8mb4";

        $this->connection = new PDO($dsn);
    }

    public function query($query)
    {
        $statement = $this->connection->prepare($query);

        $statement->execute();

        return $statement;
    }
}