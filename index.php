<?php
error_reporting(0);
session_start();

require 'database.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Welcome to Speaker Portal</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <div class="content">
        <?php require 'partials/header.php' ?>
        <div class="login-form">
            <form action="index.php" method="post">
                <?php
                if($_SERVER["REQUEST_METHOD"] == "POST")
                {
                    $myusername1=mysqli_real_escape_string($con,$_POST['username']);
                    $mypassword1=mysqli_real_escape_string($con,$_POST['password']);
                    $mypassword=MD5($mypassword1);
                    $sql="SELECT * FROM users WHERE username='$myusername1' and password='$mypassword'";
                    $result=mysqli_query($con,$sql);
                    $count=mysqli_num_rows($result);
                    if($count==1)
                    {
                        $_SESSION['logged']=true;
                        $_SESSION['username']=$myusername1;
                        header("Location: grab_and_take.php");
                        exit();
                    }
                    else
                    {
                        $_SESSION['logged']=false;
                        $error="<div class=\"hiba text-center\" >Your username or password was incorrect.</div><div class=\"hiba text-center\" > Please try it again.</div>";
                    }
                }
                ?>
                <div class="form-group">
                    <p>Please Sign in</p>  
                    <label>User name:</label>
                    <input type="text" class="form-control" required="required" name="username"  >
                </div>
                <div class="form-group">
                    <label>Password:</label>
                    <input type="password" class="form-control"  required="required" name="password">
                </div>
                <div class="form-group col-md-12 text-center">
                    <button type="submit" class="btn btn-primary btn-block">ENTER</button>
                </div>
            </form>
        </div>
        <div>
           <?php echo $error; ?>
       </div>
   </div>
   <?php require 'partials/footer.php' ?>
</body>
</html>
