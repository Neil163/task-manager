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
    $task->setUserId($_POST['userId']);
    $task->setName($_POST['name']);
    $task->setDescription($_POST['description']);

    $task->post($connection);

    header("location: index.php");
}

if (isset($_GET['delete'])) {
    $task->delete($connection, $_GET['delete']);

    header("location: index.php");
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $result = $task->select($connection, "WHERE id = {$_GET['edit']}");
    if (count($result) === 1) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $description = $row['description'];
    }
}

if(isset($_POST['update'])) {
    $id = $_POST['id'];
    $task->setName($_POST['name']);
    $task->setDescription($_POST['description']);

    $task->update($connection, (int)$id);

    header("location: index.php");
}



