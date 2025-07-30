<?php // nope
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'student')) { // Check for both admin and student roles

	if (isset($_POST['id']) && isset($_POST['title']) && isset($_POST['description']) && isset($_POST['assigned_to']) && isset($_POST['due_date'])) {
        include "../DB_connection.php";
        include_once "Model/Task.php";

	
    function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$title = validate_input($_POST['title']);
	$description = validate_input($_POST['description']);
	$assigned_to = validate_input($_POST['assigned_to']);
	$id = validate_input($_POST['id']);
	$due_date = validate_input($_POST['due_date']);
	$priority = validate_input($_POST['priority']);


	if (empty($title)) {
		$em = "Title is required";
	    header("Location: ../edit-task.php?error=$em&id=$id");
	    exit();
	}else if (empty($description)) {
		$em = "Description is required";
	    header("Location: ../edit-task.php?error=$em&id=$id");
	    exit();
	}else if ($assigned_to == 0) {
		$em = "Select User";
	    header("Location: ../edit-task.php?error=$em&id=$id");
	    exit();
	} else if (empty($priority)) {
		$em = "Priority is required";
		header("Location: ../edit-task.php?error=$em&id=$id");
		exit();
	}else {
    
       include_once "Model/Task.php";

       $data = array($title, $description, $assigned_to, $due_date, $priority, $id);
	   $update_success = update_task($conn, $data);

if ($update_success) {
    error_log("Task with ID: " . $id . " updated successfully.");
} else {
    error_log("Failed to update task with ID: " . $id);
}
    //    update_task($conn, $data);

       $em = "Task updated successfully";
	    header("Location: ../edit-task.php?success=$em&id=$id");
	    exit();
    
	}
}else {
   $em = "Unknown error occurred";
   header("Location: ../edit-task.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../login.php?error=$em");
   exit();
}