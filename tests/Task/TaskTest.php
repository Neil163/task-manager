<?php


use App\Task;
use PHPUnit\Framework\TestCase;

class TaskTest extends TestCase
{
    private Task $task;

    protected function setUp(): void
    {
        $this->task = new Task("Test Name", "Description");
    }

    protected function tearDown(): void
    {

    }

    /**
     * Test a task name
     */
    public function testName()
    {
        $this->assertEquals("Test Name", $this->task->getName());
    }

    /**
     * Test a task description
     */
    public function testDescription()
    {
        $this->assertEquals("Description", $this->task->getDescrption());
    }
}