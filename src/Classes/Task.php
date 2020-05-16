<?php


namespace App;


class Task
{
    private $name;
    private $description;
    private $userId;

    /**
     * Task constructor.
     * @param string $name
     * @param string $description
     * @param int $userId
     */
    public function __construct(
        string $name = null,
        string $description = null,
        int $userId = null
    ) {
        $this->name = $name;
        $this->description = $description;
        $this->userId = $userId;
    }

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): void
    {
        $this->description = $description;
    }

    /**
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @param int $userId
     */
    public function setUserId(int $userId): void
    {
        $this->userId = $userId;
    }

    /**
     * Post a Task
     *
     * @param $connection
     */
    public function post($connection): void
    {
        $connection->query("INSERT INTO tasks (user_id, name, description) VALUES ('$this->userId', '$this->name', '$this->description')") or
            die($connection->error);
    }

    /**
     * Delete a task
     *
     * @param $connection
     * @param int $id
     */
    public function delete($connection, int $id): void
    {
        $connection->query("DELETE from tasks WHERE id = $id") or
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
    public function get($connection, string $condition = null)
    {
        $tasks = array();
        if($condition) {
            $result = $connection->query("SELECT * from tasks {$condition}") or
                die($connection->error);
        } else {
            $result = $connection->query("SELECT * from tasks") or
                die($connection->error);
        }
        while ($row = mysqli_fetch_assoc($result)) {
            $tasks[$row['id']] = array(
                'id' => $row['id'],
                'name' => $row['name'],
                'description' => $row['description'],
            );
        }

        return json_encode($tasks);
    }

    public function update($connection, int $id)
    {
        $connection->query("UPDATE tasks SET name = '$this->name', description = '$this->description' WHERE id = $id") or
            die($connection->error);
    }
}