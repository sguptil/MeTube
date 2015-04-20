<?php
// session_start();
// include_once "function.php";

// try {
// 	if (!isset($_GET['id']))
// 		throw new Exception('Bad download request - id not found');
// 	$media = get_media($_GET['id']);
// 	$AccountID = $media['AccountID'];
// 	$MediaID = $media['MediaID'];
// 	$ip = get_client_ip();



// 	//insert into download table
// 	$insertDownload = "INSERT into download(DownloadID,AccountID,MediaID,ip,downloadtime) 
// 		values(NULL,'$AccountID','$MediaID','$ip',NULL)";
// 	$queryresult = mysql_query($insertDownload);
// 	if (!$queryresult)
// 		throw new Exception("Download table query failed: ". mysql_error());

// 	header("Content-Type: ". $media['type']);
// 	header("Content-Length: " . filesize($media['filepath']));
// 	header("Content-Disposition: attachment; filename=\"". basename($media['filepath']) ."\"");
// 	readfile($media['filepath']);
// }
// catch (Exception $e) {
// 	$_SESSION['result'] = $e->getMessage();
// 	$redirect_url = (isset($_SESSION['redirect_url'])) ? $_SESSION['redirect_url'] : 'index.php';
// 	unset($_SESSION['redirect_url']);
// 	header("Location: $redirect_url", true, 303);
// }

// exit;
?>