<?php
	include 'secret.php';
	$mysqli = new mysqli($host, $user, $password, $database);
	/* check connection */
	if ($mysqli->connect_errno) {
		printf("Connect failed: %s\n", $mysqli->connect_error);
		exit();
	}



	/* close connection */
	$mysqli->close();
?>