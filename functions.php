<?php

$config = array(
		'USERNAME'	=>	'root',
		'PASSWORD'	=>	'',
		'DBNAME'	=>	'messanger'
	);
//FUNCTION FOR DATABASE CONNECTION
$conn = connect($config);
function connect($config){
	try{
		$conn = new PDO("mysql:host=localhost;dbname=".$config['DBNAME'], 
						$config['USERNAME'], $config['PASSWORD']);
		$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $conn ;
	}catch(PDOException $e){
		return false;
	}
}

function query($query,$bindings,$conn){
	$result = $conn->prepare($query);
	$result->execute($bindings);
	return $result;
}





//TABLE CREATE 
// $usertbl = "CREATE TABLE IF NOT EXISTS users(
	
// 	id INT(6) AUTO_INCREMENT NOT NULL,
// 	username VARCHAR(55) NOT NULL,
// 	PRIMARY KEY(id)

// ) ";
// if($conn->query($usertbl)){
// 	echo "user table created";
// } else{
// 	echo "user table not created";
// }

// $msgtble = "CREATE TABLE IF NOT EXISTS message(
	
// 	id INT(6) AUTO_INCREMENT NOT NULL,
// 	username VARCHAR(55) NOT NULL,
// 	message TEXT NOT NULL,
// 	time DATETIME NOT NULL,
// 	PRIMARY KEY(id)

// ) ";
// if($conn->query($msgtble)){
// 	echo "MESSAGE table created";
// } else{
// 	echo "MESSAGE table not created";
// }
