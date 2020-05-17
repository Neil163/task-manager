<?php


namespace App;


use mysqli;

class Status
{
    /**
     * Get statuses
     *
     * @param mysqli $connection
     * @return false|string
     */
    public function get(mysqli $connection)
    {
        $statuses = array();

        $result = $connection->query("SELECT * from status") or
        die($connection->error);

        while ($row = mysqli_fetch_assoc($result)) {
            $statuses[$row['id']] = array(
                'id' => $row['id'],
                'name' => $row['name'],
            );
        }

        return json_encode($statuses);
    }
}