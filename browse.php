<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
	session_start();
	include_once "function.php";
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media browse</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<script type="text/javascript" src="js/jquery-latest.pack.js"></script>
<script type="text/javascript">
function saveDownload(id)
{
	$.post("media_download_process.php",
	{
       id: id,
	},
	function(message) 
    { }
 	);
} 
</script>
</head>

<body>
<img src="data:image/jpeg;base64,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" alt="MeTube" style="width:340px;height:128px">
<p>Welcome <?php echo $_SESSION['username'];?></p>
<form action="index.php" method="post" > 
			<table>
			<tr>
			<td>
			<input type="submit" class="button" value="Log Out"></div>
			</td>
			</tr>
			</table>
			</form> </br>
<form action="update.php" method="post" > 
			<table>
			<tr>
			<td>
			<input type="submit" class="button" value="update"></div>
			</td>
			</tr>
			</table>
			</form> </br>
<form action='media_upload.php'> 
<input type="submit" value="Upload File">
</form>
<div id='upload_result'>
 
<?php 
	if(isset($_REQUEST['result']) && $_REQUEST['result']!=0)
	{		
		echo upload_error($_REQUEST['result']);
	}
?>
</div>
<br/><br/>
<?php

	$query = "SELECT * from media"; 
	$result = mysql_query( $query );
	if (!$result){
	   die ("Could not query the media table in the database: <br />". mysql_error());
	}
?>
    
    <div style="background:#339900;color:#FFFFFF; width:150px;">Uploaded Media</div>
	<table width="50%" cellpadding="0" cellspacing="0">
		<?php
			while ($result_row = mysql_fetch_row($result)) //filename, username, type, mediaid, path
			{ 
				$mediaid = $result_row[3];
				$filename = $result_row[0];
				$filenpath = $result_row[4];
		?>
        	 <tr valign="top">			
			<td>
					<?php 
						echo $mediaid;  //mediaid
					?>
			</td>
                        <td>
            	            <a href="media.php?id=<?php echo $mediaid;?>" target="_blank"><?php echo $filename;?></a> 
                        </td>
                        <td>
            	            <a href="<?php echo $filenpath;?>" target="_blank" onclick="javascript:saveDownload(<?php echo $result_row[4];?>);">Download</a>
                        </td>
		</tr>
        	<?php
			}
		?>
	</table>
   </div>
  
</body>
</html>
