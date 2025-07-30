<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    // Check if the user is either an admin or a student and that required POST data is set
    if ((isset($_POST['title']) && isset($_POST['description']) && isset($_POST['assigned_to']) && isset($_POST['due_date'])) && 
        ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'student')) {

        include "../DB_connection.php";

    function validate_input($data) {
	  $data = trim($data);
	  $data = stripslashes($data);
	  $data = htmlspecialchars($data);
	  return $data;
	}

	$title = validate_input($_POST['title']);
	$description = validate_input($_POST['description']);
	$assigned_to = ($_POST['assigned_to'] == 'Just me' || $_POST['assigned_to'] == '0') ? $_SESSION['id'] : (is_numeric($_POST['assigned_to']) ? (int) $_POST['assigned_to'] : NULL);
	$due_date = validate_input($_POST['due_date']);
	$priority = validate_input($_POST['priority']);

	// $assigned_to = !empty($_POST['assigned_to']) ? validate_input($_POST['assigned_to']) : NULL;
	// $due_date = !empty($_POST['due_date']) ? validate_input($_POST['due_date']) : NULL;

	if (empty($title)) {
		$em = "Title is required";
	    header("Location: ../create_task.php?error=$em");
	    exit();
	}else if (empty($description)) {
		$em = "Description is required";
	    header("Location: ../create_task.php?error=$em");
	    exit();
	}else if ($assigned_to === 0 || $assigned_to === NULL || !isset($assigned_to)) {
		$assigned_to = $_SESSION['id'];
	}else {
    
       include_once "Model/Task.php";
       include "Model/Notification.php";

       $data = array($title, $description, $assigned_to, $due_date, $priority);
       insert_task($conn, $data);

       $notif_data = array("'$title' has been assigned to you.", $assigned_to, 'New Task Assigned');
       insert_notification($conn, $notif_data);

       $em = "Task created successfully";
	    header("Location: ../create_task.php?success=$em");
	    exit();
    
	}
}else {
   $em = "Unknown error occurred";
   header("Location: ../create_task.php?error=$em");
   exit();
}

}else{ 
   $em = "First login";
   header("Location: ../create_task.php?error=$em");
   exit();
}