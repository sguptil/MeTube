<?php
session_start();
include_once "function.php";
if(isset($_POST['submit'])) {
	$username = $_POST['username'];
	if($username == "" || $_POST['password'] == "") {
		$login_error = "<h3>!!One or more fields are missing!!</h3>";
	}
	else {
		$check = user_pass_check($username,$_POST['password']); // Call functions from function.php
		if($check == 1) {
			$login_error = "User ".$username." not found";
		}
		elseif($check == 2) {
			$login_error = "Incorrect password: ". mysql_error();
		}
		else if($check == 0) {
			$acc_result = mysql_query("SELECT AccountID,username from account where username='$username'");
			$account = mysql_fetch_assoc($acc_result);
			
			$_SESSION['AccountID'] = $account['AccountID'];
			$_SESSION['username'] = $account['username'];
			$redirect_url = (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url'] : 'index.php';
			unset($_SESSION['redirect_url']);
			header("Location: $redirect_url", true, 303);
			exit;
		}	
	}
}
?>
<link rel="stylesheet" type="text/css" href="css/default.css" />

<html>	
	<head>
	<style>
	div 
	{
     width: 500px;
     padding: 20px;
     border: 20px solid gray;
     margin-left: 18%;
	 margin-top:9%;
	 
    }
</style>
</head>
	<body bgcolor=#f3f3f3>
	<img src="http://i247.photobucket.com/albums/gg153/sstruckmann/owls2.jpg" background-color:"#f3f3f3">
	
	<img class="irc_mi" style="margin-center: 20px;" src= "http://i247.photobucket.com/albums/gg153/sstruckmann/img_tree.png" width="350" height="500" align="right">
	<form method="post" action="login.php">
		<tr>
		<div>	<td width="20%">Username:</td>
			<td width="80%"><input class="text"  type="text" name="username"><br><br></td>
		</tr>
		<tr>
			<td width="20%">Password:</td>&nbsp;
			<td width="80%"><input class="text"  type=password name="password"><br></td>
		</tr>
		<tr>
		<td><br><input name="submit" type="submit" value="Login"></td>&nbsp;&nbsp;&nbsp;&nbsp;
		<td><input name="reset" type="reset" value="Reset"><br></td><br>
		</tr></form>
	<form action="register.php" method="post"> 
			<table>
			<tr>
			<td>
			<input type="submit" class="button" value="Sign-Up"></div>
			</td>
			</tr>
			</table>
	</form>
	</body>
	</html>
	<?php
	   if(isset($login_error))
	  { echo "<h2 id='passwd_result'>". $login_error ."</h2>";}
   ?>