<html>
	<head>
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
session_start();

include_once "function.php";


if(isset($_POST['submit'])) {

	if( $_POST['password1'] != $_POST['password2'] || $_POST['username'] == "") {
		$register_error = "<h2>Passwords don't match OR one or more fields missing Try again?</h2>";
	}
	else if (!filter_var($_POST["email"], FILTER_VALIDATE_EMAIL)) {
       $register_error= "<h2>Invalid email format</h2>"; 
     }
   
	else {
		
		$check = user_exist_check(NULL,$_POST['username'],$_POST['lastname'], $_POST['password1'], $_POST['gender'], $_POST['dateofbirth'] ,$_POST['email']);	
		if($check == 1){
			//echo "Rigister succeeds";
			$_SESSION['username']=$_POST['username'];
			header('Location: browse.php');
		}
		else if($check == 2){
			$register_error = "<h2>Username already exists. Please use a different username.</h2>";
		}
	}
}


?>


<form action="register.php" method="post">

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
		
        <td></br><input type="radio" name="gender" value="male">Male</td>
        <td></br><input type="radio" name="gender" value="female">Female</td>
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
   {  echo "<div id='passwd_result'> <h2> REGISTER_ERROR: </h2>".$register_error."</div>";}
?>
</body>
</html>