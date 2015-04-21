<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
    include_once "function.php";
    $username = $_SESSION['username'];
    $query = "select * from account where username='$username'";
    $result = mysql_query( $query );
    $row = mysql_fetch_row($result);
    $userid = $row[0];
    $flag = 0;
    
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

<b><a target="_self" href="compose.php">New Message</a></b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a target="_self" href="outbox.php">Outbox</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a target="_self" href="inbox.php">Inbox</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a target="_self" href="contacts.php"></a>

<br/>
  
<?php
  
if(isset($_POST['submit']))
{
    if(($_POST['receiver']=="" ))
    {
        $flag = 1;
    }
    if($_POST['subject']=="")
    {
        $flag = 2;
    }
    if($_POST['contents']=="")
    {
        $flag = 3;
    }
    
    if($flag ==1)
    echo "No recipient specified!"; 
    if($flag ==2)   
    echo "No subject specified!";
    if($flag ==3)   
    echo "No message entered!"; 
    
    else{
        
            $msg_recv = $_POST['receiver'];
            $msg_res = mysql_query("SELECT * FROM account WHERE username = '$msg_recv'") or die(mysql_error());
            if(mysql_num_rows($msg_res)==0)
            {
                echo "Invalid Username!";
            }
            else
            {
                $row1 = mysql_fetch_row($msg_res);
                $msg_recvid = $row1[0];
                $message_to = $msg_recvid;
                $subject = $_POST['subject'];
                $contents = $_POST['contents'];
                $message_from = $userid;
                $query = "INSERT INTO messages (userid,sender_accountid,timestamp,contents,subject) VALUES ('".$message_to."','".$message_from."',CURRENT_TIMESTAMP,'".$contents."','".$subject."')";
                mysql_query($query) or die(mysql_error());
                echo "Message Delivered!";
            }
    }
}
else if(isset($_POST['reset'])){}
?>    




<br/><br/>
<form method = "post" action= "" target="_self">
<table width = "100%" bgcolor="#CCCCFF">
<tr><td width = "10%"  bgcolor='#CCCCFF'><font size="-1">From :</font></td><td> <?php echo $username; ?></td><td><INPUT TYPE="submit" NAME="submit" VALUE="Send Message">&nbsp;
<INPUT TYPE="reset" NAME="reset" VALUE="Clear Message"> </td>
 </tr>
<tr><td width = "10%"  bgcolor='#CCCCFF'><font size="-1">To:</font> </td><td width="80%"  colspan="2"><input type="text" size="80" maxlength="80" name="receiver"></td></tr>
<tr><td width = "10%"  bgcolor='#CCCCFF'><font size="-1">Subject:</font></td><td width="80%"  colspan="2"> <input type="text" size="80" maxlength="80" name="subject"></td></tr>
<tr><td width = "10%"  bgcolor='#CCCCFF' valign="top"><font size="-1">Message:</font></td><td width="80%"  colspan="2"><textarea name="contents" rows="8" cols="60" wrap = "hard"></textarea></td></tr>
</table>
</form>

    
    <br/>




</div> <!-- end #content -->


<?php
// include('sidebar.php'); 
?>


</div> <!-- End #wrapper -->
    
</body>
</html>