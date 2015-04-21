<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    if(isset($_GET['accountid']))
    {
        $accountid=$_GET['accountid'];
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
<?php
if($_SESSION['username'])
{
    ?>

 <a target="_self" href="compose.php">Compose</a> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b><a target="_self" href="inbox.php">Inbox</a></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a target="_self" href="outbox.php">Outbox</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a target="_self" href="contacts.php"></a><br/>
 <br/> 
 
    <form method = "post" action= "inbox.php" target="_self">
    <table width="100%">
      <tr>
      
<?php
 $query="SELECT * FROM messages WHERE userid = '".$userid."' ORDER BY timestamp DESC ";
 $result = mysql_query($query) or die(mysql_error());
    if(mysql_num_rows($result)==0)
        echo "<p align='center'>None.</p>";
    else{
        echo "<tr'><b><td>Message</td><td  width='35%'>Received at</td><td width='25%'>From</td></b></tr>";
        while($row=mysql_fetch_array($result))
        {
            $messageid=$row['message_id'];
            $content=$row['contents'];
            $sender=$row['sender_accountid'];
            $y="SELECT * FROM account WHERE userid = '".$sender."'";
            $r = mysql_query($y) or die(mysql_error());
            $w = mysql_fetch_row($r);
            $sender1 = $w[1];
            $subject=$row['subject'];
            $time=$row['timestamp'];
            $recv_del=$row['recv_flag'];
            $unread=$row['unread'];
    
            if(!$recv_del) //if the msg is in inbox
            {
                echo "<tr><td align='center'><a href='message.php?id=".$messageid."'>";
                echo "<b>".$subject."</b>";
                echo "</a></td><td align='center' class='style3'>".$time."</td><td class='style3' align='center'>".$sender1."</td></tr>";
            }
        }
    }
}
    else {
	    echo "<h1>login to gain access</h1>";
    }
?>
       
      </tr>
    </table>
    </form>
    <br/>
</div>

  </div>
    
</body>
</html>