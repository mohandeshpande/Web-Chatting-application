<html>
<head><title>Login Message Board-</title>
</head>
    <body >
        <h1>Login Page</h1>
        <div style="background-color:#D3D3D3";>
        <form action ="" method ="post">
            <b>UserName:</b> <input type="text" name="Username"><br>
           <b> Password:</b> <input type="password" name="password" ><br><br>
                    <input type="submit" name ="login" value = "Login">
                    <br/>
                    <P><i>Please enter the username and password as it is in the 'users' table.</i></P>
        </form>
      </div>
        <?php
            session_start();
            error_reporting(E_ALL);
            ini_set('display_errors','On');
            $username = "";
            $fullname= "";

            
         
            if (isset($_POST['login'])) {
              $username = $_POST["Username"];    
            }
            try {
              $dbh = new PDO("mysql:host=127.0.0.1;dbname=board","root","",array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));              
              $dbh->beginTransaction();             

              $stmt = $dbh->prepare('select * from users');
              $stmt->execute();
          
              while ($row = $stmt->fetch()) {                  
                  if (($row['username']==$username  )&&($row['password']==$_POST["password"]))
                      {     
                      $_SESSION["username"]=$username;
                      $_SESSION["fullname"]=$row['fullname'];
                      header("Location: board.php");
                      exit;
                      
                  }
                  else
                    { 
                     

                      

                  }
                  
                  
              }   
              
              print "</pre>";
            } catch (PDOException $e) {
              print "Error!: " . $e->getMessage() . "<br/>";
              die();
            }
            
        ?>

    </body>      
</html>





