<?php
	session_start();
	include_once "function.php";
?>

<html>
<head>
<title>Profile - MeTube</title>
<style>
	table 
	{
		width: 350px;
		height: 240px;
		padding: 50px;
		border: 10px solid #f3f3f3;
		margin-left: 28%;
		margin-top:9%;
		background-color:#cccccc;
	 
    }
	body  
	{
		background-image: url("http://i164.photobucket.com/albums/u8/hemi1hemi/COLOR/imagine.jpg");
		background-color: #cccccc;
	}
	</style>
	</head>
<body bgcolor=#f3f3f3>

<?php
if(isset($_POST['submit'])) {
	
	if($_POST['password1'] == "") {
			$register_error = "<h1>!!One or more fields are missing!!</h1>";
	
	if( $_POST['password1'] != $_POST['password2']){
		$register_error = "<h2>Passwords don't match. Try again?</h2>";		
	}
}		
	else {
		
		if(!isset($username)){
			mysql_query("UPDATE account SET username='".$_POST['username']."' WHERE username='".$_SESSION['username']."'") or die(mysql_error());
			
		}
		if(!isset($lastname)){
		  mysql_query("UPDATE account SET lastname='".$_POST['lastname']."' WHERE username='".$_SESSION['username']."'") or die(mysql_error());
			
		}
		
		if(!isset($password)){
			mysql_query("UPDATE account SET password='".$_POST['password1']."' WHERE username ='".$_SESSION['username']."'")or die(mysql_error());
		}
		if(!isset($gender)){
		mysql_query("UPDATE account SET gender='".$_POST['gender']."' WHERE username = '".$_SESSION['username']."'")or die(mysql_error());
			
		}
		if(!isset($dateofbirth)){
		mysql_query("UPDATE account SET dateofbirth='".$_POST['dateofbirth']."' WHERE username = '".$_SESSION['username']."'")or die(mysql_error());
			
		}
		if(!isset($email)){
		mysql_query("UPDATE account SET email='".$_POST['email']."' WHERE username = '".$_SESSION['username']."'")or die(mysql_error());
			
		}
			//echo "Update succeeds";
			$_SESSION['username'] = $_POST['username'];
		header('Location: index.php');
		}
		
		}			
	
?>

 <form action="profile.php" method="post">
 
	<table width="20%">
		<tr>
		<td width="20%">username:</td>
		<td width="80%"><input type="text" name="username"></td>
		</tr>
		<tr>
		<td width="20%">lastname:</td>
			<td width="80%"><input type="text" name="lastname"></td>
		</tr>
		<tr>
		<td width="20%">email:</td>
			<td width="80%"><input type="text" name="email"></td>
		</tr>
		<tr>
			<td width="20%">CreatePassword:</td>
			<td width="80%"><input type=password name="password1"></td>
		</tr>
		<tr>
			<td width="20%">ConfirmPassword:</td>
			<td width="80%"><input type=password name="password2"></td>
		</tr>
		
        <td></br><input type="radio" name="gender" value="Male">male</td>
        <td></br><input type="radio" name="gender" value="Female">female</td>
      </tr>
		<tr>
		<td>
		dateofbirth:<input type="date" name="dateofbirth"> 
		</td>		
		</tr>
		<tr>
		<td>
		<br><input name="submit" type="submit" value="Submit">
		</td>
		</tr>
		</table>
		</form>
<?php
  if(isset($register_error))
   {  echo "<id='passwd_result'>".$register_error."";}
?>

</body>
</html>