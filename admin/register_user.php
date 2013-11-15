<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Register user</title>
<link rel="stylesheet" href="../mystyle.css">
</head>


<body>
    <div id="content">
	<?php 
          include '../header.php'; 
          include '../functions/db_connect.php';
          $db=db_connect();
          $rights=array();
          $rights[1]="Reader";
          $rights[2]="Writer";
          $rights[3]="Admin";
        ?>

	<div id="wrapper">
            
           <?php
           //Deals with the content of the form if we come from register_user.php
            if(isset($_POST) && !empty($_POST))
            {
                //If the form to add a new user is filled in, check if the username already exists.
                //If not insert it. If yes, or if the password is left blank display an alert.
                if(isset($_POST['username']) && !empty($_POST['username']))
                {
                    $username=  mysqli_real_escape_string($db, $_POST['username']);
                    $sql="SELECT ID FROM user WHERE Username='".$username."' AND Is_deleted=0";
                    $result=db_query($db, $sql);
                    $num_rows = mysqli_num_rows($result);
                    if($num_rows==0 && $_POST['password']!='')
                    {
                        $password=  mysqli_real_escape_string($db, $_POST['password']);
                        $md5_password=md5($password);
                        $sql = "INSERT INTO user (ID, Username, Password, Access) VALUES('', '".$username."', '".$md5_password."', ".$_POST['access'].")";
                        db_query($db, $sql);
                        echo "New user successfully registered <br>";
                    }
                    elseif($num_rows!=0){
                        echo'<script language="JavaScript"> alert("This username is already in use, please chose another one"); </script>';
                    }
                    elseif($_POST['password']==''){
                        echo'<script language="JavaScript"> alert("Password cannot be left empty"); </script>';
                    }
                }
                //Deletes a current user
                if(isset($_POST['delete']) && !empty($_POST['delete']))
                {
                    foreach($_POST['delete'] as $ID => $delete)
                    {
                        $sql="UPDATE user SET Is_deleted=1 WHERE ID=".$ID;
                        db_query($db, $sql);
                    }
                    echo "User(s) successfully deleted <br>";
                }
                //Updates the access privileges of a current user
                if(isset($_POST['update_access']) && !empty($_POST['update_access']))
                {
                    foreach($_POST['update_access'] as $ID => $access)
                    {
                        $sql="UPDATE user SET Access=".$access." WHERE ID=".$ID;
                        db_query($db, $sql);
                    }
                    echo "User(s) successfully updated <br>";
                }
           }
            ?>
            <!--Displays the form to Create a new user, update the access privileges of a current user or delete a current user-->
            <div id="centre">
                <h3>Register a new user</h3>
                <br>
                <form method="post" action="register_user.php" enctype="multipart/form-data" class="login" autocomplete="off">
                    Username: <input type="text" name="username" /> </br>
                    <br>
                    Password: <input type="password" name="password" /><br>
                    <br>
                    Access: <select name="access">
                    <option value="1">Reader</option>
                    <option value="2">Writer</option>
                    <option value="3">Admin</option>
                    </select><br>
                    <br>
                    <input type="submit" value="Register">
                </form> 
                <br>
                <br>
            
                <h3>Current users</h3>
                <form method="post" action="register_user.php" enctype="multipart/form-data" class="normal" autocomplete="off">
                    <table width="100%" align="centre">
                        <tr><th>Delete?</th><th>User Name</th><th>Access</th><th>Added date</th></tr>
                        <?php 
                        $sql="SELECT ID, Username, Access, Date_added FROM user WHERE Is_deleted=0";
                        $result = db_query($db, $sql);
                        while($data=db_fetch_assoc($result))
                        {
                            echo"<tr><td><input type='checkbox' name='delete[".$data['ID']."]' value='delete'></td>
                                <td>".$data['Username']."</td>
                                <td><select name='update_access[".$data['ID']."]'>
                                    <option value='".$data['Access']."'>".$rights[$data['Access']]."</option>
                                    <option value='1'>Reader</option>
                                    <option value='2'>Writer</option>
                                    <option value='3'>Admin</option>
                                    </select><br></td>
                                <td>".$data['Date_added']."</td>
                                </tr>";
                        }
                        db_close($db);
                        ?>
                    </table>
                    <br>
                    <input type="submit" value="Update users">
                </form>
            </div>
	</div>
    </div>
    <?php include '../footer.php'; ?>
</body>
</html>

