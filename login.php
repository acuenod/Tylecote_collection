<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Login</title>
<link rel="stylesheet" href="mystyle.css">
</head>


<body>
    <div id="content">
	<?php include 'header.php'; ?>
	<div id="wrapper">
            <form method="post" action="start_session.php" enctype="multipart/form-data" class="login" autocomplete="off">
                <h3>Please log in to continue</h3>
                Username: <input type="text" name="username" /> </br>
                <br>
                Password: <input type="password" name="password" /><br>
                <br>
                <input type="submit" value="Login">
            </form>
            <br>
            <br>
            <br>
            <div id="centre">
            This website uses first-party session cookies, necessary for the delivery of this web service and to enable individual user accounts. By logging in to this website, you agree to accept these cookies stored on your computer.
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>