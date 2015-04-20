<?php
session_start();

if (!isset($_SESSION['username'])) {
	$_SESSION['redirect_url'] = $_SERVER['PHP_SELF'];
	header('Location: login.php');
	exit;
}
$curr_user = $_SESSION['username'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Upload - Metube</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
</head>

<body>
<div id="main_container">

<div id="nav_container">
<?php echo $_SESSION['AccountID']; ?>
<h1>MeTube 2015</h1>
<h2>Upload Media</h2>
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
</ul>
</div>

<form method="post" action="media_upload_process.php" enctype="multipart/form-data" >
<p>
	Add a Media: <label style="color:#663399"><em> (Each file limit 10M)</em></label>
	<input name="file" type="file" size="50">
	<br><input name="title" type="text" placeholder="Title" size="50">
	<br><textarea name="description" placeholder="Description" rows="4" columns="50"></textarea>
	<br><input name="keywords" type="text" placeholder="Keywords" size="50">
	<br>
</p>
<input value="Upload" name="submit" type="submit" />
</form>

</div>

</body>
</html>
