<?php
session_start();
include_once "function.php";

// Check file for errors
try {
	// Ensure user is logged in
	$username = $_SESSION['username'];
	$AccountID = $_SESSION['AccountID'];
	if (!isset($username) || !isset($AccountID) || $AccountID == 0)
		throw new Exception('No user login found'. $_SESSION['AccountID']);

	//Create Directory if doesn't exist
	if(!file_exists('uploads/')){
	 	mkdir('uploads/');
		chmod("uploads/", 0755);
	}

	// Check overloaded parameters
	if (!isset($_FILES['file']['error']) || is_array($_FILES['file']['error']))
		throw new Exception('Invalid parameters');

	// Check file error
	$error_check = upload_error($_FILES['file']['error']);
	if ($error_check !== "UPLOAD_ERR_OK")
		throw new Exception($error_check);

    // Create user uploads folder if not found
	$dirfile = "uploads/".$username."/";
	if (!file_exists($dirfile)) {
		mkdir($dirfile);
		chmod($dirfile, 0755);
	}

	// Check if file already exists
	$upfile = $dirfile.urlencode($_FILES["file"]["name"]);
	if (file_exists($upfile))
		throw new Exception('File has already been uploaded');

	// Ensure video title is given
	if (!isset($_POST['title']) || strlen($_POST['title']) < 1)
		throw new Exception('Please enter a title for the media');

    // Move uploaded file
    if (!move_uploaded_file($_FILES['file']['tmp_name'], $upfile))
        throw new Exception('Failed to move uploaded file');
	chmod($upfile, 0755);

	// Insert into media table
	$insert = "INSERT into media(MediaID,AccountID,filename,type,filepath,title,description,keywords)" .
		  "values(NULL,'$AccountID','". urlencode($_FILES["file"]["name"]) ."','". $_FILES["file"]["type"] ."','$upfile','".
		  $_POST['title'] ."','". $_POST['description'] ."','". $_POST['keywords'] ."')";
	$queryresult = mysql_query($insert);
	if (!$queryresult)
		throw new Exception("Insert into Media error in media_upload_process.php " .mysql_error());

	// Redirect to page before media_upload.php
	$redirect_url = (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url'] : 'index.php';
	unset($_SESSION['redirect_url']);
	header("Location: $redirect_url", true, 303);
	exit;
}
catch (Exception $e){
	$_SESSION['result'] = $e->getMessage();
	header("Location: media_upload.php");
	exit;
}

?>
