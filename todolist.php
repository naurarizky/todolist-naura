<?php 
include 'db.php';

// Proses insert data
if(isset($_POST['add'])) {
    $q_insert = "INSERT INTO task (task_lable, task_status) VALUE (
        '".$_POST['task']."',
        'open'
    )";

    $run_q_insert = mysqli_query($conn, $q_insert);
    if($run_q_insert) {
        header('Refresh:0; url=todolist.php');
    }
}


//show data
$q_select = "SELECT * FROM task ORDER BY task_id DESC";
$run_q_select = mysqli_query($conn, $q_select);

//delete data
if(isset($_GET['delete'])) {
    $q_delete = "DELETE FROM task WHERE task_id = '".$_GET['delete']."' ";
    $run_q_delete = mysqli_query($conn, $q_delete);
    header('Refresh:0; url=todolist.php');
}
//update status data(open/close)
if(isset($_GET['done'])) {
    $status = 'close';
    if($_GET ['status'] == 'open') {
        $status = 'close';
    }else {
        $status = 'open';
    }

    $q_update = "UPDATE task SET task_status ='".$status."' WHERE task_id = '".$_GET['done']."'  ";
    $run_q_update = mysqli_query($conn, $q_update);
    header('Refresh:0; url=todolist.php');
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>To Do List</title>
    <!--link css-->
    <link rel ="stylesheet" href="gayeak.css">
    <!-- box icon -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>

</head>
<body>
    <div class="container">
    <!-- ini untuk header -->
        <div class="header">
            <div class="title">
            <i class='bx bx-sun'></i>
            <span>To Do List</span>
            </div>
            <div class="description">
                <?= date("l, d M Y")?>
            </div>
    </div>
    <!-- ini untuk konten -->
    <div class="content">
        <div class="card">
            <form action="" method="post">
                <input name="task"   type="text" class="input-control" placeholder="Add Task">
                <div class="text-right">
                    <button type="submit"  name="add">Add</button>
                </div>
            </form>
        </div>
    <!-- ini untuk tugas -->
    <?php 
    if(mysqli_num_rows($run_q_select) > 0) {
        while($r = mysqli_fetch_array($run_q_select)) {
        ?>
    <div class="card">
    <div class="task-item <?= $r['task_status'] == 'close'? 'done':''?>">
        <div>
            <input type="checkbox" onclick="window.location.href = '?done=<?= $r['task_id']?>&status=<?= $r['task_status']?>'" <?= $r['task_status'] == 'close' ? 'checked':''?>>
        <span><?= $r['task_lable']?></span>
        </div>
        <div>
            <a href="edit.php?id=<?= $r['task_id']?>" class="edit-task"  title="Edit"><i class='bx bx-edit' ></i></a>
            <a href="?delete= <?= $r['task_id']?>" class="delete-task"  title="Remove" onclick="return confirm('Are you sure?')"><i class='bx bx-trash' ></i></a>
         </div>
       </div>
    </div>
    <?php }}else { ?>
        <div>Belum ada data</div>
    <?php } ?>
    
    </div>
    <div class="buttonsay">
        <a href="index.php" class="back">back</a>
    </div>
</div>




</body>
</html>
</body>
</html>
    