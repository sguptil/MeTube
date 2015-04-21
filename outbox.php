<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
if(isset($_GET['accountid']))
{
$accountid=$_GET['accountid'];
//echo "MEDIA ID IS".$id."<br/>";
}
else{
    //  print "<meta http-equiv='refresh' content='0;url=index.php'>";
}
session_start();
include_once "function.php";
    $username = $_SESSION['username'];
    $query = "select * from account where name='$username'";
    $result = mysql_query( $query );
    $row = mysql_fetch_row($result);
    $userid = $row[0];
?>

<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Media browse</title>
<link rel="stylesheet" type="text/css" href="css/default.css" />
<link rel="stylesheet" type="text/css" href="style.css" media="screen" />

</head>

<body>
<div id="wrapper">

    <?php include('nav.php'); ?>

    <div id="content">
  
<a target="_self" href="compose.php">New Message</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<b><a target="_self" href="outbox.php">Outbox</a></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a target="_self" href="inbox.php">Inbox</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a target="_self" href="contacts.php"></a>

<br/>
  
  
  
    <form method = "post" action= "inbox.php" target="_self">
      <table width="100%">
        <tr>
          <?php
 $query="SELECT * FROM messages WHERE sender_accountid = '".$userid."' ORDER BY timestamp DESC ";
 if($result === FALSE) { 
    die(mysql_error()); // TODO: better error handling
 }
 $result = mysql_query($query) or die(mysql_error());
if(mysql_num_rows($result)==0)
echo "No messages yet.";
else{

echo "<tr bgcolor='#CCCCFF'><td>Message</td><td  width='25%'>Sent at</td><td width='20%'>From</td><td width='20%'>To</td></tr>";

while($row=mysql_fetch_array($result))
    {
    $message_id=$row['message_id'];
    $recvr=$row['userid'];   
    $content=$row['contents'];
    $sender=$row['sender_accountid'];
    $subject=$row['subject'];
    $time=$row['timestamp'];
    $recv_del=$row['recv_flag'];
    $snd_flag=$row['sender_flag'];
    $qy = "select * from account where userid='".$sender."'";
    $t = mysql_query( $qy ) or die(mysql_error());
    $r2 = mysql_fetch_row($t);
    $sendname = $r2[1];
    
    
    $e = "select * from account where userid='$recvr'";
    $a = mysql_query( $e ) or die(mysql_error());
    $r3 = mysql_fetch_row($a);
    $recvname = $r3[1];
    if(!$snd_flag)
    {
     echo "<tr><td align='center'><a href='message.php?id=".$message_id."'>";
     echo $subject; 
     echo "</a></td><td  class='style3'>".$time."</td><td class='style3'>".$sendname."</td><td class='style3'>".$recvname."</td></tr>";
    
    }else 
    {}
    
    }
}
    ?>
        </tr>
      </table>
    </form>
    <br/>
    
    </div> <!-- end #content -->


<?php include('footer.php'); ?>             

</div> <!-- End #wrapper -->
    
</body>
</html>