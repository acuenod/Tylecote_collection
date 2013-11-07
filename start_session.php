<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<?php
    include 'functions/db_connect.php';
    $db=db_connect();

    //protect from SQL injection
    $username=mysqli_real_escape_string($db, $_POST['username']);
    $password=mysqli_real_escape_string($db, $_POST['password']);
    
    // Encrypt password with md5() function.
    $md5_password=md5($password); 

    // Check matching of username and password.
    // NB: The username isn't case sensitive (collation utf8_unicode is case-insensitive).
    // The password is case-sensitive.
    $sql="SELECT * FROM user WHERE Username='$username' AND Password='$md5_password'";
    $result=db_query($db, $sql);
    if(mysqli_num_rows($result)!='0') // If match.
    {
        $data=db_fetch_assoc($result);
        session_start();
        $_SESSION['username']=$username;
        $_SESSION['access']=$data['Access'];
    }

    db_close($db);
    header("location:index.php");
    exit;
?>