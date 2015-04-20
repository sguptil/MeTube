<?php
	session_start();
	include_once "function.php";

	// Try to delete media from database
	if (isset($_POST['id'])) {
		$MediaID = $_POST['id'];

		$path_query = "SELECT filepath FROM media WHERE MediaID='$MediaID'";
		$path_result = mysql_query($path_query);
		if (!$path_result)
			die ("Could not query the media table in the database <br>". mysql_error());
		$path_result_row = mysql_fetch_row($path_result);

		$del_query = "DELETE FROM media WHERE MediaID='$MediaID'";
		$del_result = mysql_query($del_query);
		if (!$del_result)
			die ("Could not query the media table in the database: <br>". mysql_error());

		if (!unlink($path_result_row[0]))
			die ("Could not delete file from server");
	}

	// Redirect back
	$redirect_url = (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url'] : './';
	unset($_SESSION['redirect_url']);
	header("Location: $redirect_url", true, 303);
	exit;
?>