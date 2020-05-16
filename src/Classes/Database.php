<?php


namespace App;


use mysqli;

class Database
{
    private $host = 'localhost';
    private $username = 'mysql';
    private $password = 'mysql';
    private $db = 'task_manager';

    /**
     * Connect to a dataBase
     *
     * @return mysqli
     */
    public function connect()
    {
        $mysqli = new mysqli($this->host, $this->username, $this->password, $this->db) or die(mysqli_error($mysqli));

        return $mysqli;
    }
}