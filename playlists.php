<?php
	session_start();
	include_once "function.php";

	if (!isset($_SESSION['AccountID']) || !isset($_SESSION['username'])) {
		$_SESSION['redirect_url'] = $_SERVER['PHP_SELF'];
		header('Location: login.php');
		exit;
	}
	$curr_user = $_SESSION['username'];
	$curr_acc = $_SESSION['AccountID'];
	$getNewName = False;

	if (isset($_POST['remove'])) {
		if (!isset($_POST['MediaID']) || !isset($_POST['PlaylistID']))
			trigger_error("Can't find MediaID/PlaylistID to remove ".mysql_error());

		$rem_result = mysql_query("DELETE from ptrack where PlaylistID='". $_POST['PlaylistID'] ."' AND MediaID='". $_POST['MediaID'] ."'");
		if (!$rem_result)
			trigger_error("Failed to remove media from playlist");
		unset($_POST['remove']);
	}
	else if (isset($_POST['add'])) {
		if (!isset($_POST['playlist']) || !isset($_POST['MediaID']))
			trigger_error("Can't find playlist/MediaID to add ".mysql_errno());
		$name = $_POST['playlist'];
		$MediaID = $_POST['MediaID'];

		// insert new row into playlist
		if (isset($_POST['new-name'])) {
			$name = $_POST['new-name'];
			if (strlen($name) > 50 || strlen($name) < 4) {
				$_SESSION['result'] = "Invalid playlist name (4-50 characters required)";
				header("Location: playlists.php");
				exit;
			}

			$new_pla_result = mysql_query("INSERT into playlist values(NULL,'$curr_acc','$name')");
			if (!$new_pla_result) {
				trigger_error("Failed to add new playlist. ". mysql_error());
			}
			unset($_POST['new-name']);
		}
		// insert new row into ptrack
		if ($name !== "new") {
			$pla_result = mysql_query("SELECT PlaylistID from playlist where AccountID='$curr_acc' AND name='$name'");
			if (!$pla_result)
				trigger_error("Failed to find playlist ". mysql_error());
			$playlist = mysql_fetch_assoc($pla_result);

			$tra_result = mysql_query("INSERT into ptrack values(NULL,'". $playlist['PlaylistID'] ."','". $MediaID ."')");
			if (!$tra_result) 
				trigger_error("Failed to add new playlist track". mysql_error());
		}
		// need to get new playlist name after loading navmenu
		else
			$getNewName = True;
		unset($_POST['add']);
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<title>Playlists - MeTube</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
</head>

<body>

<div id="main_container">

<div id="nav_container">
<h1>MeTube 2015</h1>
<h2><?php echo $curr_user ?> Playlists</h2>
<?php 
	if (isset($_SESSION['result']))
		echo "<h2>". $_SESSION['result'] ."</h2>";
?>

<ul class="nav" alt="Navigation tab">
	<a href="profile.php"><li style="border-left-width: 4px">
		<img width="52px" height="52px" src="images/User.png"/>
		<br><b>Profile</b>
	</li></a>
	<a href="index.php"><li>
		<img width="52px" height="52px" src="images/Browse.png"/>
		<br><b>Browse</b>
	</li></a>
	<a href="channel.php?id=<?php echo $curr_user ?>"><li>
		<img width="52px" height="52px" src="images/Channel.png"/>
		<br><b>Channel</b>
	</li></a>
	<a href="media_upload.php"><li>
		<img width="52px" height="52px" src="images/Upload.png"/>
		<br><b>Upload</b>
	</li></a>
	<a href="favorites.php"><li>
		<img width="52px" height="52px" src="images/Favorites.png"/>
		<br><b>Favorites</b>
	</li></a>
	<a href="messaging.php"><li>
		<img width="52px" height="52px" src="images/Messaging.png"/>
		<br><b>Inbox</b>
	</li></a>
	<a href="logout.php"><li>
		<img width="52px" height="52px" src="images/Logout.png"/>
		<br><b>Logout</b>
	</li></a>
</ul>
</div>

<?php
	// Get new playlist name
	if ($getNewName) {
?>
	<div id="media_container">
		<form method="post" action="playlists.php">
		<input type="hidden" name="MediaID" value="<?php echo $MediaID ?>">
		New playlist name: <input type="text" name="new-name">
		<input type="submit" name="add" value="Save">
		</form>
	</div>
<?php
	}
	else {
		$pla_result = mysql_query("SELECT PlaylistID,name from playlist where AccountID='". $_SESSION['AccountID'] ."'");
		while ($playlist = mysql_fetch_assoc($pla_result)) {
	?>
		<div id="media_container">
		<ul class="media">
		<?php
			echo "<h2 id=\"playlist\">". $playlist['name'] ."</h2>";

			$tra_result = mysql_query("SELECT MediaID from ptrack where PlaylistID='". $playlist['PlaylistID'] ."'");
			while ($track = mysql_fetch_assoc($tra_result)) {
				$med_result = mysql_query("SELECT AccountID,type,filepath,title from media where MediaID='". $track['MediaID'] ."'");
				$media = mysql_fetch_assoc($med_result);

				$acc_result = mysql_query("SELECT username from account where AccountID='". $media['AccountID'] ."'");
				$account = mysql_fetch_assoc($acc_result);

				if (strpos($media['type'], 'image') !== FALSE)
					$thumbnail = $media['filepath'];
				else
					$thumbnail="images/Play.png";
		?>
				<li class="media">
					<p>
					<a class="media" href="media.php?id=<?php echo $media['MediaID'] ?>">
						<img src="<?php echo $thumbnail ?>" width="200px" height="150px">
					</a>
					<br><a class="media" id="title" href="media.php?id=<?php echo $track['MediaID'] ?>"><b><?php echo mb_strimwidth($media['title'], 0, 40, "...");?></b></a>
					<br>by: <a class="media" id="uploader" href="channel.php?id=<?php echo $account['username']?>"><i><?php echo $account['username']; ?></i></a>
					<form method="post" action="playlists.php">
						<input name="PlaylistID" type="hidden" value="<?php echo $playlist['PlaylistID'] ?>">
						<input name="MediaID" type="hidden" value="<?php echo $track['MediaID'] ?>">
						<input name="remove" type="submit" value="Remove">
					</form>
					</p
				</li>
		<?php
			}
		?>
		</ul>
	</div>
	<?php
		}
	}
?>

</div>

</body>
</html>