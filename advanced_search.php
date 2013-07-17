<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Advanced Search</title>
<link rel="stylesheet" href="mystyle.css">
</head>


<body>
    <div id="content">
        <?php include 'header.php'; ?>
        <div id="wrapper">
            <h1>Advanced search</h1>

            <?php 
            include 'functions/db_connect.php';
           
            $db=db_connect();

            db_close($db);
            ?>

        </div>
    </div>
<?php include 'footer.php'; ?>
</body>
</html> 
