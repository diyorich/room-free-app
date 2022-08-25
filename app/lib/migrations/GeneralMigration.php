<?php

namespace App\lib\migrations;

use App\Lib\Database;

class GeneralMigration
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function prepareEnvironment()
    {
        try {
            $this->db->startTransaction();
            $this->createRoomTable();
            $this->createRoomRecods();
            $this->createRoomScheduleTable();

        } catch (\Exception $exception) {
            echo $exception->getMessage();
            $this->db->rollBackTransaction();
        }
    }

    private function createRoomTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS rooms(
                id INT(5) NOT NULL UNIQUE,
                name VARCHAR(50))";

        $this->db->query($sql);
    }

    private function createRoomRecods()
    {
        $sql = "INSERT INTO rooms(id, name)
                VALUES(1, 'first'), 
                      (2, 'second'),
                      (3, 'third'),
                      (4, 'fourth'),
                      (5, 'fifth')";

        $this->db->query($sql);
    }

    private function createRoomScheduleTable()
    {
        $sql = "CREATE TABLE IF NOT EXISTS room_schedules(
                room_id INT NOT NULL,
                r_from DATETIME,
                r_to DATETIME,
                reserved_by VARCHAR(100) NOT NULL,
                mail VARCHAR(100),
                token VARCHAR(20) UNIQUE)";

        $this->db->query($sql);
    }
}
