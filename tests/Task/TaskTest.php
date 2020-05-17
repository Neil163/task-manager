<?php


use App\Database;
use App\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    private Task $task;
    private mysqli $connection;

    protected function setUp(): void
    {
        $this->task = new Task();
        $database = new Database();
        $this->connection = $database->connect();
    }

    protected function tearDown(): void
    {
        $this->connection->close();
    }

    /**
     * Немного перепутал и написал не юнит тест, удалять жалко(
     * Test crud a task from db
     */
    public function testCRUDTask()
    {
        $taskId = null;
        $rand = rand(1, 9000000);
        $conditionByName = "WHERE name = 'testName {$rand}'";
        $testTask = new Task(
            "testName {$rand}",
            "description",
            1,
            2
        );
        //create a task
        $testTask->create($this->connection);
        //get a task
        $taskArrayCreated = json_decode($testTask->getTasks($this->connection, $conditionByName), true);
        //check the created task
        $this->assertIsArray($taskArrayCreated);
        foreach ($taskArrayCreated as $array) {
            $this->assertEquals($testTask->getName(), $array['name']);
            $this->assertEquals($testTask->getDescription(), $array['description']);
            $taskId = $array['id'];
        }
        //update the created task
        $testTask->setName("updateName {$rand}");
        $testTask->setDescription("description update");
        $testTask->update($this->connection, $taskId);
        $conditionById = "WHERE id = '{$taskId}'";
        $taskArrayUpdate = json_decode($testTask->getTasks($this->connection, $conditionById), true);
        $this->assertEquals($testTask->getName(), $taskArrayUpdate[$taskId]['name']);
        $this->assertEquals($testTask->getDescription(), $taskArrayUpdate[$taskId]['description']);
        //delete the task
        $testTask->delete($this->connection, $taskId);
        //get deleted task
        $taskArrayDeleted = json_decode($testTask->getTasks($this->connection, $conditionById), true);
        $this->assertEquals(404, $taskArrayDeleted);

    }

    /**
     * Test a task name
     */
    public function testSetGetName()
    {
        $testData = "Test Name";
        $this->task->setName($testData);
        $this->assertEquals($testData, $this->task->getName());
    }

    /**
     * Test a task description
     */
    public function testSetGetDescription()
    {
        $testData = "Description";
        $this->task->setDescription($testData);
        $this->assertEquals($testData, $this->task->getDescription());
    }

    /**
     * Test a task user id
     */
    public function testSetGetUserId()
    {
        $testData = 2;
        $this->task->setUserId($testData);
        $this->assertEquals($testData, $this->task->getUserId());
    }

    /**
     * Test a task status id
     */
    public function testStatusId()
    {
        $testData = 2;
        $this->task->setUserId($testData);
        $this->assertEquals($testData, $this->task->getUserId());
    }
}