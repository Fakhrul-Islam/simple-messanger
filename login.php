<?php
	session_start();
	if( isset($_SESSION['username']) ){
		header( 'Location:index.php?u='.$_SESSION['username'] );
		exit();
	}
	include_once("functions.php");
	if( isset($_POST['username']) && isset($_POST['password']) ){
		$username = htmlspecialchars(trim($_POST['username'])) ;
		$password =	htmlspecialchars(trim($_POST['password']));
		$query = query("SELECT * FROM users WHERE username = :username",array('username'=>$username),$conn);
		if($query->rowCount()<=0){
			echo "Sorry Your username could not found...please regester first";
			exit();
		}else{
			$query = $query->fetchAll();

			foreach ($query as $row){
				$spassword = $row['password'];
			}
			if ( $password == $spassword ){
				$_SESSION['username'] = $username;
				echo "login_success";
				exit();
			}else{
				echo "Your Password does'nt match!";
				exit();
			}
		}
	}
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Login</title>
	<script src="ajax.js"></script>
	<style>
		body{background:#ccc; font-size:14px;}
		.container{width:960px; margin:0 auto;text-align: center;}
		.loginform{margin-top:30%;}
		ul{margin:0;padding: 0;list-style:none;}
		label{display:block;}
		input {background: #fff none repeat scroll 0 0;border: 1px solid #ddd;font-size: 14px; padding: 5px;width: 180px;}
		#loginbtn,.register {cursor: pointer;margin-top: 5px;width: 57px;}
	</style>
	<script>
		function loginBtn(){
			var status = document.getElementById('status');
			var username = document.getElementById('username').value;
			var password = document.getElementById('password').value;
			if( username=="" || password=="" ){
				status.innerHTML='<span style="color:red">Please Enter User Id and Password</span>';
			}else{
				var ajax = ajaxObj("POST","login.php" );
				ajax.onreadystatechange = function(){
						if(ajaxReturn(ajax)==true){
							var response = ajax.responseText
							if( response == "login_success" ){
								window.location = "index.php?u="+username;
								;
							}else {
								status.innerHTML="<span style='color:red;'>"+response+"</span>"
							}
						}
					}
					ajax.send("username="+username+"&password="+password);
				}
		}
	</script>
</head>
<body>
	<div class="container">
		<form class="loginform">
			<ul>
				<li>
					<label for="username">User Name : </label>
					<input type="text" name="username" placeholder="Username" id="username">
				</li>
				<li>
					<label for="password">Password : </label>
					<input type="password" name="password" placeholder="Password" id="password">
				</li>
				<li>
					<input type="button" name="button" value="Login" id="loginbtn" onclick="loginBtn();">
					<p id="status"></p>
				</li>
				<li><a href="register.php" class="register">Register</a></li>
			</ul>
		</form>
	</div>
</body>
</html>