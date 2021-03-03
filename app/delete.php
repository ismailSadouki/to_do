<?php
    require "config.php";
    if(!empty($_GET['task_id'])) {
        $connection->query("DELETE FROM tasks WHERE id = '".$_GET['task_id']."' AND user_id = '".$_SESSION['user_id']."' AND done = 1 " );
    }
    header('Location: ../index.php');
?>