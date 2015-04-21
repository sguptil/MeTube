<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<?php
    session_start();
    include_once "function.php";
    if (isset($_GET['message_id'])){
        $messageid=$_GET['message_id'];
    }
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

<script type="text/javascript" language="javascript">
function confirm_box()
{
alert("Are you sure ?");
}
</script> 
</head>

<body>
<div id="wrapper">

    <?php include('nav.php'); ?>


    <div id="content">

<a target="_self" href="compose.php">New Message</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a target="_self" href="inbox.php">Inbox</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
<a target="_self" href="outbox.php">Outbox</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;

<a target="_self" href="contacts.php"></a>

<br/><br/><br/><br/>
  <?php
     $q1="SELECT * from messages where message_id='".$messageid."';";
    $res1 = mysql_query($q1) or die(mysql_error());
    $r1= mysql_fetch_array($res1);
    $subject=$r1['subject'];
    $content=$r1['contents'];
    $sender=$r1['sender_accountid'];
    $time=$r1['timestamp'];
    $sender_flag=$r1['sender_flag'];
    $recv_flag=$r1['recv_flag'];
    $message_recv=$r1['userid'];
if($message_recv == $userid) //if i am the reciever??
{
            if(isset($_POST['delete'])) //if i wanted to delete it
            {
                if($sender_flag==1) //and it exists in outbox
                {
                    $del="DELETE from messages where message_id=".$messageid; //i delete it
                }
                else //if its not in outbox; then it should be in inbox and so i am setting it.....
                {
                    $del = "UPDATE messages set recv_flag=1 where message_id=".$messageid;
                }
                 $del_res = mysql_query($del) or die(mysql_error());
                print "<meta http-equiv='refresh' content='3;url=inbox.php'>"; //after i have deleted the msg it goes to inbox.
            }
    
            if($recv_flag==0) //if the msg is not in inbox....i display the msg??
            {
             ?>
                <form method = "post" action= "message.php?id=<?php echo $messageid; ?>" >
                <table bgcolor="#CCCCFF" width="100%">
                  <tr>
               <?php
                 $y="SELECT * FROM account WHERE userid = '".$sender."'";
    $r = mysql_query($y) or die(mysql_error());
    $w = mysql_fetch_row($r);
    $sender1 = $w[1];
               echo "<tr><td colspan='2' width='30%'><b>Subject:</b></td><td align='left'>".$subject."</td></tr>";
               echo "<tr><td colspan='2' width='30%'><b>From:</b></td><td  align='left'>".$sender1."</td></tr>";
              echo "<tr><td><b>Time:</b></td><td>".$time."</td> <td  colspan='2' align='right'><input type='submit' name='delete' id='delete'  value ='Delete Message' /></td></tr>"; 
              
                 echo "<tr bgcolor='#FFFFFF'><td colspan='4'>".$content."<br/><br/></td></tr>";
               
               ?>   
                  </tr>
                </table>
                </form>
                <br/>
                <?php }
                else{echo "Message Deleted!";}
 } 
 else if($sender==$userid) //if i am the reciever.....
 {
        if(isset($_POST['delete'])) //if i wanted to delete it
        {
                if($recv_flag==1) //if the msg is in inbox....i delete it
                {
                    $del="DELETE from messages where message_id=".$messageid;
                        }
                else //i say that it is in outbox....
                {
                    $del = "UPDATE messages set sender_flag=1 where message_id=".$messageid;
                }
                 $del_res = mysql_query($del) or die(mysql_error());
        print "<meta http-equiv='refresh' content='3;url=inbox.php'>"; //and i redirect to inbox...
        }
             
         if($sender_flag==0) //if it is not in outbox....i display the msg...
         {
                 ?>
                    <form method = "post" action= "message.php?id=<?php echo $messageid; ?>" >
                    <table width="100%" bgcolor="#CCCCFF">
                      <tr>
                   <?php
                     $y="SELECT * FROM account WHERE userid = '".$message_recv."'";
                     $r = mysql_query($y) or die(mysql_error());
                     $w = mysql_fetch_row($r);
                     $message_recv1 = $w[1];
                   echo "<tr><td><b>Receiver:</b></td><td>".$message_recv1."</td><td><b>Time:</b></td><td>".$time."</td><td><input type='submit' name='delete' id='delete' value ='Delete Message' /></td></tr>";
                   echo "<tr bgcolor='#FFFFFF'><td colspan='5'>".$content."<br/><br/></td></tr>";
                   ?>   
    <?php //               </tr> ?>
                    </table>
                    </form>
                    <br/>
                
                <?php
        }
        else{echo "Message Deleted!";} 
} 
 else{
    
    print "<meta http-equiv='refresh' content='3;url=index.php'>";
     }
    ?>
  
    
    
</div> <!-- end #content -->


</div> <!-- End #wrapper -->
    
</body>
</html>