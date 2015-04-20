<?php
session_start();
include_once "function.php";

if(isset($_POST['submit'])) {
	if($_POST['password1'] != $_POST['password2']) {
		$register_error = "Passwords do not match. Try again?";
	}
	else {
		$check_code = user_exist_check($_POST['username'], $_POST['password1']);
		if($check_code == 1) {
			$_SESSION['username'] = $_POST['username'];
			header("Location: index.php");
		}
		else if($check_code == 2) {
			$register_error = "Username already exists. Please change the username.";
		}
	}
}
?>

<html>
<body>

<div class="main_container">

<form action="register.php" method="post">
	Username: <input type="text" name="username"> <br>
	Create Password: <input type="password" name="password1"> <br>
	Repeat Password: <input type="password" name="password2"> <br>
	<input name="submit" type="submit" value="Submit">
</form>

<?php
	if (isset($register_error)) {
		echo "<div id='passwd_result'> register_error: " . $register_error . "</div>";
	}
?>
</div>

</body>
</html>
