<?php

namespace App\Lib;

class Database
{
    private $host;

    private $pass;

    private $user;

    private $dbname;

    private $connection;

    public function __construct()
    {
        $this->host = DB_HOST;
        $this->pass = DB_PASS;
        $this->user = DB_USER;
        $this->dbname = DB_NAME;

        try {
            $this->connection = mysqli_connect($this->host, $this->user, $this->pass, $this->dbname);
        } catch (\Exception $exception)
        {
            //TODO write occured exception into logger
        }
    }

    public function queryExecute(string $query)
    {
        $result = mysqli_query($this->connection, $query);
        return mysqli_fetch_all($result, MYSQLI_ASSOC);
    }

    public function query(string $query)
    {
        $this->connection->query($query);
    }

    public function startTransaction()
    {
        $this->connection->begin_transaction();
    }

    public function rollBackTransaction()
    {
        $this->connection->rollback();
    }
}
