<?php 

require 'app/config.php'; 
$user_id = $_SESSION['user_id'];
$result = $connection->query("SELECT id,description,done,due_date FROM tasks WHERE user_id = $user_id");

$tasks = $result->num_rows > 0 ? $result : []; 
?>
<!DOCTYPE html>

<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>ادارة المهام</title>
	<link rel="stylesheet" href="css/index.css">
</head>
<body>
	<div class="container">
		<h1 class="header">
			مهماتي
		</h1>
		<?php if(empty($tasks)):?>
			<p>لم تقم باضافة اي مهمة للقيام بها</p>
		<?php else:?>	
			<?php foreach($tasks as $task):?>
				<ul class="tasks">
					<li >
						<span class="task <?php echo $task['done'] ? 'done' : '' ?>"><?php echo $task['description']?></span>
						<?php if($task['done']):?>
							<a href="app/delete.php?task_id=<?php echo $task['id'] ?>" class="task-buttons">حذف المهمة</a>
						<?php else:?>	
						<a href="app/mark.php?task_id=<?php echo $task['id'] ?>" class="task-buttons">تم الانجاز</a>
						<?php  endif;?>
						<?php $task['due_date'] = strtotime($task['due_date']); ?>
						<p class="date">اخر تاريخ لانجاز المهمة:<?php echo date('Y-m-d', $task['due_date']) ?></p>
					</li>
				</ul>
			<?php endforeach;?>
		<?php endif;?>	
		<?php
		if(isset($_SESSION['errors'])){
			foreach($_SESSION['errors'] as $error){
				echo "<p class=\"error\">$error</p>";
			}
			$_SESSION['errors'] = [];
		}
		
		?>
		<form action="app/add.php" method="POST" class="add-task">

			<input name="task_name" type="text" placeholder="ادخل وصف مهمة جديدة" class="input">
			<input name="due_date" type="text" placeholder="ادخل اخر تاريخ لانجاز مهمة ,مثال: 1-1-2021" class="input">
			<input type="submit" value="اضف" class="submit">
		</form>
	</div>
</body>
</html>