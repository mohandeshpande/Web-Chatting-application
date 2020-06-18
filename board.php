<html>
<head><title>Message Board-</title>
<h1>Message Board</h1>
</head>
<body>
  <div style="background-color:#D3D3D3"; text-align:center;>
          
    <form id = "textid" action = "" method="post">
        Messages: <textarea name="message" rows="7" cols="40" value="Messages"></textarea><br>
        <input type="submit" value = "Post" name="newmessage"/>
        <input type="submit" value = "LogOut" name="logout"/>
        <br/>
        <br/>
    
<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors','On');
$newmessage="";
$replyid="";

              
try {
  $dbh = new PDO("mysql:host=127.0.0.1;dbname=board","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));

  $dbh->beginTransaction();
  $uid = "";
  $uid= $_SESSION["username"];
  
    if (((isset($_POST['newmessage'])) || (isset($_GET['replyto'])) ) && (!empty($_POST['message'])) ) {           
        $newmessage = $_POST["message"];
        $mid = uniqid() ;
        $replyto = null;
      if(isset($_GET["replyto"])){
        $replyto = $_GET["replyto"];
      }
            $dbh->exec('insert into posts(id, replyto,postedby,datetime, message) values("'.$mid.'","'.$replyto.'","'.$uid.'",NOW(),"'.$newmessage.'")')
            or die(print_r($dbh->errorInfo(), true));
            $dbh->commit();
            header("Location: board.php");
            exit;

            
        
    }

      
    if (isset($_POST['logout'])) {
       
		unset($_SESSION["username"]);
		session_destroy();
    header("Location: login.php");
        exit;
    }
  
  
  $stmt = $dbh->prepare('select id,postedby,datetime,replyto,message,fullname from posts,users where users.username=posts.postedby order by datetime');
  $stmt->execute();
  
  print "<table border='1'> <tr> <th>Message id</th> <th>UserName </th> <th>Full Name</th> <th>Date and Time</th> <th>Reply To</th> <th>Message Text</th> <th>Reply</th> </tr>";
    $htmlobj ="";
  while ($row = $stmt->fetch()) {
        $replyid= $row['id'];
        $htmlobj.=  "<tr> <td>" . $replyid. "</td> <td>" . $row['postedby'] . "</td> <td>" . $row['fullname']."</td> <td>" . $row['datetime'] . "</td> <td>" . $row['replyto'] . "</td> <td>" . $row['message'] . "</td> <td><button type='submit' form='textid' formmethod='POST'  formaction ='board.php?replyto=".$replyid."'>Reply</button></td> </tr>";
  } 
  $htmlobj.="</table>";
  echo $htmlobj;
  
  
} catch (PDOException $e) {
  print "Error!: " . $e->getMessage() . "<br/>";
  die();
}
     
            
?>
</form> 
   
</body>
</html>
