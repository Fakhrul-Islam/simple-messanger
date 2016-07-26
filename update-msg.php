<?php
	include_once('functions.php');
	$conn = connect($config);
	$user = $_POST['username'];
	$msg = htmlspecialchars(trim($_POST['message'])) ;

	$insert = query("INSERT INTO message(username,message) VALUES(:u,:m)",array('u'=>$user,'m'=>$msg),$conn );
	if( $insert ){
		echo "updated";
		exit();	
	}
	
		
	
?>

