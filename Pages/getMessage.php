<?php
	error_reporting(0);
	include_once("dbConnect.php");
	if ($db->connect_error) {
		die("Sorry, there was a problem connecting to our database.");
	}
	
	$username = htmlspecialchars($_GET['username']);
	
	$result = $db->prepare("SELECT * FROM message");
	$result->bind_param("s", $username);
	$result->execute();
	
	$result = $result->get_result();
	while ($r = $result->fetch_row()) {
		echo $r[0];
		echo "\\";
		echo $r[1];
		echo "\n";
	}
?>	