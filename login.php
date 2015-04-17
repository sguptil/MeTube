<link rel="stylesheet" type="text/css" href="css/default.css" />

<?php
session_start();

include_once "function.php";

if(isset($_POST['submit'])) {
		if($_POST['username'] == "" || $_POST['password'] == "") {
			$login_error = "<h3>!!One or more fields are missing!!</h3>";
		}
		else {
			$check = user_pass_check($_POST['username'],$_POST['password']); // Call functions from function.php
			if($check == 1) {
				$login_error = "<h2>User ".$_POST['username']." not found.</h2>";
			}
			elseif($check==2) {
				$login_error = "<h2>!!Incorrect password!!</h2>";
			}
			else if($check==0){
				$_SESSION['username']=$_POST['username']; //Set the $_SESSION['username']
				header('Location: browse.php');
			}		
		}
}

?>
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
		</tr>
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
	  { echo "<id='passwd_result'>".$login_error."";}
   ?>
