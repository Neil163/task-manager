<!DOCTYPE html>
<html lang='ru'>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1, shrink-to-fit=no'>
    <title>Добро пожаловать!</title>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js" integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI" crossorigin="anonymous"></script>
</head>
<body>
    <?php require_once 'process.php';
        use App\Database;
        use App\Task;
    ?>

    <?php
        $database = New Database();
        $connection = $database->connect();
        $tasks = new Task();

        $result = $tasks->select($connection);
    ?>
    <div class = "container">
    <div class = "row justify-content-center">
        <table class = "table">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Location</th>
                    <th colspan="2">Action</th>
                </tr>
            </thead>
            <?php
                while ($row = mysqli_fetch_assoc($result)): ?>
            <tr>
                <td><?php echo $row['name']?></td>
                <td><?php echo $row['description']?></td>
                <td>
                    <a href="index.php?edit=<?php echo $row['id']; ?>"
                        class = "btn btn-info">Edit</a>
                    <a href="process.php?delete=<?php echo $row['id']; ?>"
                       class = "btn btn-danger">Delete</a>
                </td>
                <?php endwhile;?>
            </tr>
        </table>
    </div>

    <div class = "row justify-content-center">
        <form action="process.php" method="post">
            <input type="hidden" name = "id" value = "<?php echo $id; ?>">
            <div class = "form-group">
                <label>userId</label>
                <input type="text" name="userId" class="form-control" placeholder="userId">
          </div>
            <div class = "form-group">
                <label>Task name</label>
                <input type="text" name="name" class="form-control"
                       value="<?php echo $name; ?>" placeholder="Enter task name">
            </div>
            <div class = "form-group">
                <label>Description</label>
                <input type="text" name="description" class="form-control"
                       value="<?php echo $description; ?>" placeholder="Enter description">
            </div>
            <div class="form-group">
                <?php
                    if($update == "true"):
                ?>
                <button type="submit" class="btn btn-info" name="update">Update</button>
                <?php else:?>
                <button type="submit" class="btn btn-primary" name="save">Save</button>
                <?php endif?>
            </div>
        </form>
    </div>
    </div>
</body>
</html>