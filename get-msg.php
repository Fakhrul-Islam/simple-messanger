<?php
	header("content-type:application/json");
	include_once('functions.php');
	$conn = connect($config);
	$query = query("SELECT * FROM message",array(),$conn);
	$row = $query->fetchAll();
	echo json_encode($row);
	
	exit();
	
?>