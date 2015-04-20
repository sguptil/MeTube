<?php 
	session_start();
	include_once "function.php";

	if (!isset($_GET['id'])) {
		$_SESSION['result'] = "Channel not found";
		$redirect_url = (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url'] : 'index.php';
		unset($_SESSION['redirect_url']);
		header("Location: $redirect_url", true, 303);
		exit;
	}
	$_SESSION['redirect_url'] = $_SERVER['PHP_SELF'];
	$owner = $_GET['id'];

	// Check if user is the owner
	$curr_user = $_SESSION['username'];
	if ($curr_user == $owner)
		$is_owner = TRUE;

	$acc_result = mysql_query("SELECT AccountID from account where username='$owner'");
	$account = mysql_fetch_assoc($acc_result);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Channel - MeTube</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>
<div id="main_container">

<div id="nav_container">
<h1>MeTube 2015</h1>
<h2><?php echo $owner ?> Channel</h2>
<?php
	if (isset($_SESSION['result'])) {
		echo "<h3>". $_SESSION['result'] ."</h3><br>";
		unset($_SESSION['result']);
	}
?>
<ul class="nav" alt="Navigation tab">
	<a href="index.php"><li id="first">
		<img width="52px" height="52px" src="images/Browse.png"/>
		<br><b>Browse</b>
	</li></a>
<?php 
	if(isset($curr_user)) { 
?>
		<a href="channel.php?id=<?php echo $curr_user?>"><li>
			<img width="52px" height="52px" src="images/Channel.png"/>
			<br><b>Channel</b>
		</li></a>
		<a href="media_upload.php"><li>
			<img width="52px" height="52px" src="images/Upload.png"/>
			<br><b>Upload</b>
		</li></a>	
		<a href="playlists.php"><li>
			<img width="52px" height="52px" src="images/Playlists.png"/>
			<br><b>Playlists</b>
		</li></a>
		<a href="favorites.php"><li>
			<img width="52px" height="52px" src="images/Favorites.png"/>
			<br><b>Favorites</b>
		</li></a>
		<a href="messaging.php"><li>
			<img width="52px" height="52px" src="images/Messaging.png"/>
			<br><b>Inbox</b>
		</li></a>
		<a href="profile.php"><li style="border-left-width: 4px">
			<img width="52px" height="52px" src="images/User.png"/>
			<br><b>Profile</b>
		</li></a>
		<a href="logout.php"><li id="last">
			<img width="52px" height="52px" src="images/Logout.png"/>
			<br><b>Logout</b>
		</li></a>
<?php
	}
	else {
?>
		<a href="login.php"><li id="first">
			<img width="52px" height="52px" src="images/Login.png">
			<br><b>Login
		</li></a>
		<a href="register.php"><li id="last">
			<img width="52px" height="52px" src="images/Register.png">
			<br><b>Register
		</li></a>
<?php
	}
?>
</ul>
</div>

<!-- query table for all media -->
<?php
	$result = mysql_query("SELECT MediaID,type,filepath,title from media where AccountID='". $account['AccountID'] ."'");
	if (!$result)
	   die ("Could not query the media table in the database: <br />". mysql_error());
?>
<div id="media_container">
<ul class="media" alt="Channel media list">
<?php
	while ($media = mysql_fetch_assoc($result)) 
	{ 
		if (strpos($media['type'], 'image') !== FALSE)
			$thumbnail = $media['filepath'];
		else
			$thumbnail="images/Play.png"
?>
		<li class="media">
			<a class="media" href="media.php?id=<?php echo $media['MediaID'] ?>">
				<img src="<?php echo $thumbnail ?>" width="200px" height="150px">
			</a>
			<br><a class="media" id="title" href="media.php?id=<?php echo $media['MediaID'] ?>"><?php echo mb_strimwidth($media['title'], 0, 25, "...");?></a>
			<br>by: <a class="media" id="uploader" href="channel.php?id=<?php echo $owner ?>"><?php echo $owner; ?></a>
			<br>
<?php
			if ($curr_user === $user_channel) {
?>
				<form method="post" action="delete.php" style="display: inline;">
					<input type="hidden" name="id" value="<?php echo $MediaID ?>">
					<button type="submit">Delete</button>
				</form>
<?php
		}
?>
		</li>
<?php
	}
?>
</div>

</div>

</body>

</html>