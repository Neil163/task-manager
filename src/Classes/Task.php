<?php


namespace App;


use mysqli;

class Task
{
    private $taskTable = "tasks";
    private $userTable = "users";
    private $statusTable = "status";
    private $name;
    private $description;
    private $userId;
    private $statusId;

    /**
     * Task constructor.
     *
     * @param string $name
     * @param string $description
     * @param int $userId
     * @param int|null $statusId
     */
    public function __construct(
        string $name = null,
        string $description = null,
        int $userId = null,
        int $statusId = null
    )
    {
        $this->name = $name;
        $this->description = $description;
        $this->userId = $userId;
        $this->statusId = $statusId;
    }

    /**
     * Get a name
     *
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * Set a name
     *
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * Get a description of task
     *
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * Set a description of task
     *
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * Get an user id
     *
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * Set an user id
     *
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * Get a status id of the task
     *
     * @return mixed
     */
    public function getStatusId()
    {
        return $this->statusId;
    }

    /**
     * Set a status id of the task
     *
     * @param int $statusId
     */
    public function setStatusId(int $statusId): void
    {
        $this->statusId = $statusId;
    }

    /**
     * Post a task
     *
     * @param mysqli $connection
     */
    public function post(mysqli $connection): void
    {
        $connection->query(
            "INSERT INTO {$this->taskTable} (user_id, status_id, name, description) 
                VALUES ('$this->userId','$this->statusId' , '$this->name', '$this->description')"
        ) or die($connection->error);
    }

    /**
     * Delete a task
     *
     * @param mysqli $connection
     * @param int $id
     */
    public function delete(mysqli $connection, int $id): void
    {
        $connection->query("DELETE from {$this->taskTable} WHERE id = $id") or
        die($connection->error);
    }

    /**
     * get tasks
     *
     * @param $connection
     * @param string $condition
     *
     * @return mixed
     */
    public function get(mysqli $connection, string $condition = null)
    {
        $tasks = array();
        if ($condition) {
            $result = $connection->query("
                SELECT 
                    {$this->taskTable}.id AS id, 
                    {$this->taskTable}.name as task_name, 
                    {$this->taskTable}.description as description, 
                    {$this->userTable}.name AS user_name, 
                    {$this->statusTable}.name AS status_name  
                FROM {$this->taskTable} 
                JOIN {$this->userTable} ON tasks.user_id = users.id 
                JOIN {$this->statusTable} ON tasks.status_id = status.id 
                {$condition}
            ") or die($connection->error);
        } else {
            $result = $connection->query("
                SELECT 
                    {$this->taskTable}.id AS id, 
                    {$this->taskTable}.name as task_name, 
                    {$this->taskTable}.description as description, 
                    {$this->userTable}.name AS user_name, 
                    {$this->statusTable}.name AS status_name  
                FROM {$this->taskTable} 
                JOIN {$this->userTable} ON tasks.user_id = users.id 
                JOIN {$this->statusTable} ON tasks.status_id = status.id 
            ") or die($connection->error);
        }
        while ($row = mysqli_fetch_assoc($result)) {
            $tasks[$row['id']] = array(
                'id' => $row['id'],
                'task_name' => $row['task_name'],
                'description' => $row['description'],
                'user_name' => $row['user_name'],
                'status_name' => $row['status_name'],
            );
        }

        return json_encode($tasks);
    }

    /**
     * Update a task
     *
     * @param mysqli $connection
     *
     * @param int $id
     */
    public function update(mysqli $connection, int $id)
    {
        $connection->query(
            "UPDATE {$this->taskTable} 
                SET 
                    user_id = '$this->userId', 
                    status_id = '$this->statusId' , 
                    name = '$this->name', 
                    description = '$this->description' 
                WHERE id = $id"
        ) or die($connection->error);
    }
}