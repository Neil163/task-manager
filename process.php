<?php

require "vendor/autoload.php";

use App\Database;
use App\Task;

$id = null;
$name = null;
$description = null;
$update = null;

$database = new Database();
$connection = $database->connect();
$task = new Task();

if (isset($_POST['save'])) {
    if (empty($_POST['userId']) || empty($_POST['name']) || empty($_POST['description'])) {
        echo "Error: please enter a data in all fields";
    } else {
        $task->setUserId($_POST['userId']);
        $task->setName($_POST['name']);
        $task->setDescription($_POST['description']);

        $task->post($connection);

        header("location: index.php");
    }
}

if (isset($_GET['delete'])) {
    $task->delete($connection, $_GET['delete']);

    header("location: index.php");
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = json_decode($task->get(
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

if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $task->setName($_POST['name']);
    $task->setDescription($_POST['description']);

    $task->update($connection, (int)$id);

    header("location: index.php");
}


