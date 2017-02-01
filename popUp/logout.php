<?php
	session_start();
	include_once("dbConnect.php");
	$user = $_SESSION['user'];
	
	$result = $db->prepare("delete from message where username=?");
	$result->bind_param("s", $user);
	$result->execute();
	
	$result = $db->prepare("delete from user where username=?");
	$result->bind_param("s", $user);
	$result->execute();
	
	$_SESSION['user'] = "";
	$_SESSION['user'] = 0;
	
	header("location:index.php");
	exit();
	
?>