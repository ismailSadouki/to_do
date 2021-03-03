<?php
require "config.php";

function validate_date($date_string){
    if ($time = strtotime($date_string)) {
        return $time;
    } else {
        return false;
    }
}

if($_SERVER['REQUEST_METHOD'] === 'POST'){

	//اختبار عدم فراغ حقلي وصف المهمة و التاريخ
	if((!empty($_POST['task_name'])) and (!empty($_POST['due_date'])))
	{
		//اختبار صحة التاريخ المدخل
		if($due_date = validate_date($_POST['due_date'])){
			//تخزين المهمة داخل قاعدة البيانات
			$description = $_POST['task_name'];
			$due_date = date('Y-m-d H:i:s', $due_date);
			$connection->query("INSERT INTO tasks (description, user_id, due_date) VALUES ('".$description."', '".$_SESSION['user_id']."', '".$due_date."')");
		}
		//التاريخ المدخل غير صحيح
		else {
			//ارسال رسالة خطأ
			$errors['not_valid_date'] = 'يجب ان تدخل التاريخ بصورة صحيحة مثل :1-1-2021';
			$_SESSION['errors'] = $errors;

		}
	}
	//احد الحقلين او كليهما فارغين
	else {
			//ارسال رسالة خطأ
			if(empty($_POST['task_name'])){
				$errors['required_name'] = 'يجب ان تقوم بكتابة وصف للمهمة';
			}
			if(empty($_POST['due_date'])){
				$errors['required_date'] = 'يجب ان تقوم بتعيين اخر مهلة لانجاز المهمة';
			}
			$_SESSION['errors'] = $errors;
			
	}
	header('Location: ../index.php');
}

