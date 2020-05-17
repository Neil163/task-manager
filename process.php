<?php

require "vendor/autoload.php";

use App\Database;
use App\Status;
use App\Task;
use App\User;

$id = null;
$name = null;
$description = null;
$update = null;
$filterStatusId = null;

$database = new Database();
$connection = $database->connect();
$task = new Task();
$users = new User();
$statuses = new Status();

$tasksArray = json_decode($task->getJoin($connection, $filterStatusId), true);
$statusesArray = json_decode($statuses->get($connection), true);
$usersArray = json_decode($users->get($connection), true);

//Save a task functionality
if (isset($_POST['save'])) {
    if (empty($_POST['userId']) || empty($_POST['name']) || empty($_POST['description']) || empty($_POST['statusId'])) {
        echo "Error: please enter a data in all fields";
    } else {
        $task->setUserId($_POST['userId']);
        $task->setName($_POST['name']);
        $task->setDescription($_POST['description']);
        $task->setStatusId($_POST['statusId']);

        $task->create($connection);

        header("location: index.php");
    }
}

//Delete a task functionality
if (isset($_GET['delete'])) {
    $task->delete($connection, $_GET['delete']);

    header("location: index.php");
}

//Edit button is pressed
if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = json_decode($task->getTasks(
        $connection,
        "WHERE id = {$_GET['edit']}"),
        true
    );
    if (count($result) === 1) {
        $row = $result;
        $name = $row[$id]['name'];
        $description = $row[$id]['description'];
    }
}

//Filter button is pressed
if (isset($_GET['filter'])) {
    $filterStatusId = $_GET['filter'];
    $tasksArray = json_decode($task->getJoin(
        $connection,
        "WHERE status_id = {$_GET['filter']}"
    ), true);
}

//Clear filter button is pressed
if (isset($_GET['clear'])) {
    $filterStatusId = $_GET['clear'];
    $tasksArray = json_decode($task->getJoin($connection, $filterStatusId), true);
}

//Update a task functionality
if(isset($_POST['update'])) {
    if (empty($_POST['userId']) || empty($_POST['name']) || empty($_POST['description']) || empty($_POST['statusId'])) {
        echo "Error: please enter a data in all fields";
    } else {
        $id = $_POST['id'];
        $task->setUserId($_POST['userId']);
        $task->setName($_POST['name']);
        $task->setDescription($_POST['description']);
        $task->setStatusId($_POST['statusId']);

        $task->update($connection, (int)$id);

        header("location: index.php");
    }
}

$connection->close();