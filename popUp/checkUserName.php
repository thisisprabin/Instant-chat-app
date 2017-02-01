<?php
	include_once("dbConnect.php");
	$username = stripslashes(htmlspecialchars($_REQUEST['username']));
	$result = $db->prepare("SELECT username FROM user where username = ?");
	$result->bind_param("s", $username);
	$result->execute();
	
	$result = $result->get_result();
	while ($r = $result->fetch_row()) {
		if($r[0] == $username){
			echo "1";
		} else {
			echo "0";
		}
	}
?>