<?php
    require "config.php";
    if(!empty($_GET['task_id'])) {
        $connection->query("UPDATE tasks SET done=1 WHERE id = '".$_GET['task_id']."' AND user_id = '".$_SESSION['user_id']."'");
    }
    header('Location: ../index.php');
?>