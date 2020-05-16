<?php


namespace App;


class User
{
    public function get($connection)
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