<?php
	session_start();
	include_once "function.php";

	if (isset($_SESSION['username']))
		$curr_user = $_SESSION['username'];

	$_SESSION['redirect_url'] = $_SERVER['PHP_SELF'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>MeTube Browse</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<div id="main_container">

<div id="nav_container">
<h1>MeTube 2015</h1>
<h2>Browse</h2>
<?php
	if (isset($_SESSION['result'])) {
		echo "<h3>". $_SESSION['result'] ."</h3><br>";
		unset($_SESSION['result']);
	}
?>
<ul class="nav" alt="Navigation tab">
<?php
	if (isset($curr_user))
	{
?>
		<a href="channel.php?id=<?php echo $curr_user?>"><li id ="first">
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
		<a href="profile.php"><li>
			<img width="52px" height="52px" src="images/User.png"/>
			<br><b>Profile</b>
		</li></a>
		<a href="logout.php"><li id="last">
			<img width="52px" height="52px" src="images/Logout.png"/>
			<br><b>Logout</b>
		</li></a>
<?php 
	}
	else 
	{
?>
		<a href="login.php"><li id="first">
			<img width="52px" height="52px" src="images/Login.png">
			<br><b>Login</b>
		</li></a>
		<a href="register.php"><li id="last">
			<img width="52px" height="52px" src="images/Register.png">
			<br><b>Register</b>
		</li></a>
<?php
	}
?>
</ul>
</div>

<?php
	$result = mysql_query("SELECT MediaID,AccountID,type,filepath,title from media");
	if (!$result)
	   die ("Could not query the media table in the database: <br />". mysql_error());
?>
<div id="media_container">
<ul class="media" alt="Media list">
<?php
	while ($media = mysql_fetch_assoc($result)) 
	{
		$acc_result = mysql_query("SELECT username from account where AccountID='". $media['AccountID'] ."'");
		$account = mysql_fetch_assoc($acc_result);

		if (strpos($media['type'], 'image') !== FALSE)
			$thumbnail = $media['filepath'];
		else
			$thumbnail = "images/Play.png";
?>
		<li class="media">
			<p>
			<a class="media" href="media.php?id=<?php echo $media['MediaID'] ?>">
				<img src="<?php echo $thumbnail ?>" width="200px" height="150px">
			</a>
			<br><a class="media" id="title" href="media.php?id=<?php echo $media['MediaID'] ?>"><b><?php echo mb_strimwidth($media['title'], 0, 40, "...");?></b></a>
			<br>by: <a class="media" id="uploader" href="channel.php?id=<?php echo $account['username']?>"><i><?php echo $account['username']; ?></i></a>
			</p
		</li>
<?php
	}
?>
</ul>
</div>

</div>

</body>