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
            $this->connection = new \mysqli($this->host, $this->user, $this->pass, $this->dbname);
        } catch (\Exception $exception)
        {
            //TODO write occured exception into logger
        }
    }

    public function queryExecute(string $query)
    {
        return $this->connection->query($query)->fetch_all();
    }
}
