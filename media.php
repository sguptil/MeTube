<?php
	session_start();
	include_once "function.php";

	if (!isset($_GET['id'])) {
		$_SESSION['result'] = "Media not found";
		$_SESSION['redirect_url'] = $_SERVER['PHP_SELF'];
		header('Location: index.php');
		exit;
	}

	if (isset($_SESSION['username']))
		$curr_user = $_SESSION['username'];
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">	

<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media</title>
<script src="Scripts/AC_ActiveX.js" type="text/javascript"></script>
<script src="Scripts/AC_RunActiveContent.js" type="text/javascript"></script>
</head>

<body>
<div id="main_container">

<div id="nav_container">
<h1>MeTube 2015</h1>
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

<div id="media_container">

<div class="view">
<?php
	$MediaID = $_GET['id'];
	$med_result = mysql_query("SELECT AccountID,type,filepath,title,description from media where MediaID='$MediaID'");
	$media = mysql_fetch_assoc($med_result);
	$acc_result = mysql_query("SELECT username from account where AccountID='". $media['AccountID'] ."'");
	$account = mysql_fetch_assoc($acc_result);
	
	// updateMediaTime($media['MediaID']);
	
	// check if media is image
	if(substr($media['type'],0,5) == "image")
		$isImage = TRUE;
	// check if media is video
	else if(substr($media['type'],0,5) == "video")
		$isVideo = TRUE;
	// check if media is audio
	else if(substr($media['type'],0,5) == "audio")
		$isAudio = TRUE;

	if ($isVideo) {
?>
		<!-- Display video controller -->
		<video max-width="auto" height="auto" controls>
			<source src="<?php echo $media['filepath'] ?>" type="<?php echo $media['filetype'] ?>">
		Your browser does not support HTML5 video.
		</video>
		<br>
<?php
	}
	else if ($isAudio) {
?>
		<!-- Display audio controller -->
		<audio max-width="auto" height="auto" controls>
			<source src"<?php echo $media['filepath'] ?>" type="<?php echo $media['filetype'] ?>">
		Your browser does not support the audio element.
		</audio>
		<br>
<?php
	}
	else if ($isImage) {
?>
		<!-- Display image -->
		<img src="<?php echo $media['filepath'] ?>" max-width="auto" height="auto">
		<br>
<?php
	}
?>
	<!-- Display media information -->
	<p>
		<!-- title, uploadedBy, description -->
		<b><?php echo $media['title']; ?></b>
		<br>by: <a class="media" id="uploader" href="channel.php?id=<?php echo $account['username'] ?>"><i><?php echo $account['username']; ?></i></a>
		<br><?php echo $media['description']; ?>
		<br>

<?php
	if (isset($curr_user)) {
		$acc_result = mysql_query("SELECT AccountID from account where username='$curr_user'");
		$account = mysql_fetch_assoc($acc_result);

		$pla_result = mysql_query("SELECT PlaylistID,name from playlist where AccountID='". $account['AccountID'] ."'");
?>
	<form method="post" action="playlists.php" style="display: inline;">
		<input type="hidden" name="MediaID" value="<?php echo $MediaID ?>">
		<select name="playlist">
			<option value="new">Add to new playlist</option>
		<?php
			while ($playlist = mysql_fetch_assoc($pla_result)) {
		?>
				<option value="<?php echo $playlist['name'] ?>">Add to <?php echo $playlist['name'] ?></option>
		<?php
			}
		?>
		</select>
		<button type="submit" name="add" style="display: inline;">Go</button>
	</form>
<?php
	echo $MediaID;
	}
?>
</p>
</div>

</div>

</div>
</body>
</html>
