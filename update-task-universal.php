<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

	if (isset($_POST['id']) && isset($_POST['status']) && isset($_POST['priority']) && 
   ($_SESSION['role'] == 'student' || $_SESSION['role'] == 'admin')) {
        include "../DB_connection.php";

    function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$status = validate_input($_POST['status']);
	$priority = validate_input($_POST['priority']);
	$id = validate_input($_POST['id']);

	if (empty($status)) {
		$em = "status is required";
	    header("Location: ../edit-task-universal.php?error=$em&id=$id");
	    exit();
		
	} else if (empty($priority)) {
		$em = "Priority is required";
		header("Location: ../edit-task-universal.php?error=$em&id=$id");
		exit();
	}
	else {
    
       include_once "Model/Task.php";

       $status_data = array($status, $id);
	   update_task_status($conn, $status_data);

	   $priority_data = array($priority, $id);
	   update_task_priority($conn, $priority_data);

       $em = "Task updated successfully";
	    header("Location: ../edit-task-universal.php?success=$em&id=$id");
	    exit();

    
	}
}else {
   $em = "Unknown error occurred";
   header("Location: ../edit-task-universal.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../login.php?error=$em");
   exit();
}