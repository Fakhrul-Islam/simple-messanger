<?php
	session_start();

	if( empty($_SESSION['username'] ) || empty($_GET['u'])  ){
		header('Location:login.php');
		exit();
	}
	include_once('functions.php');
	$conn = connect($config);
	$user = $_SESSION['username'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Simple Messanger</title>
	<style>
		body{background:#ccc; font-size:14px;}
		.container{width:500px; margin:0 auto;text-align: center;}
		#message{max-height: 400px;background-color: white;overflow: hidden;overflow-y:scroll;}
		h1.head{width:100%; background:#ddd;padding:10px 0px;margin-bottom: 0px}
		#put{margin-top:10px;}
#put_msg {background: #fff ;border: 0 solid; box-sizing: border-box;color: #010101;padding: 12px 10px; width: 100%;font-size: 14px}
		#gray{background: #ddd;padding: 10px;text-align: right;}
		#gray span, #blue span{font-size:12px; display: block}
		#blue{background:blue;text-align:left;color:#fff;padding:10px;}
	</style>
	<script src="ajax.js"></script>
	<script>
		function sendmsg(){
			var msg = document.getElementById('put_msg').value;
			var user = "<?php echo $user; ?>";
			if( msg != "" ){
				var ajax = ajaxObj("POST","update-msg.php" );
				ajax.onreadystatechange = function(){
						if(ajaxReturn(ajax)==true){
							var response = ajax.responseText
							if( response == "updated" ){
								document.getElementById('put_msg').value="";				
							}
						}
					}
					ajax.send("username="+user+"&message="+msg);
			}
		}

		function update(){
			var message = document.getElementById("message");
			var user = "<?php echo $user; ?>";
			var output = "";
			var ajax = ajaxObj("POST","get-msg.php" );
				ajax.onreadystatechange = function(){
						if(ajaxReturn(ajax)==true){

							var response = JSON.parse(ajax.responseText);
							var rl = response.length;
							var item = "";
							var output ="";

							
						var out = "";
					    var i;
					    for(i = 0; i < response.length; i++) {
					    	if ( response[i].username=="gold" ){
	out += '<p id="gray">'+response[i].message+'<span>By:'+response[i].username+'</span></p>';
					    	}else{
	out += '<p id="blue">'+response[i].message+'<span>By:'+response[i].username+'</span></p>';
					    	}
	   
					    }
							message.innerHTML=out;

						}
					}
					ajax.send();
			
		}
		setInterval(function(){ update() }, 2500);
	</script>
</head>
<body onload="update();">
	
	<div class="container">
		<h1 class="head">Simple Messanger</h1>
		<div class="logout">
			<ul>
				<li><a href="logout.php">Logout</a></li>
			</ul>
		</div>
		<div id="message">
			
			<p id="blue">Hello <span>By:User</span></p>
		</div>
		<div id="put">
			<input type="text" placeholder="Enter Your Message" id="put_msg" onkeydown="if(event.keyCode == 13) sendmsg();">
		</div>
	</div>

</body>
</html>