<?php


namespace App;


use mysqli;

class User
{
    /**
     * Get users
     *
     * @param mysqli $connection
     * @return false|string
     */
    public function get(mysqli $connection)
    {
        $users = array();

        $result = $connection->query("SELECT * from users") or
            die($connection->error);

        while ($row = mysqli_fetch_assoc($result)) {
            $users[$row['id']] = array(
                'id' => $row['id'],
                'name' => $row['name'],
            );
        }

        return json_encode($users);
    }
}