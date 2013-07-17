<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Delete object</title>
<link rel="stylesheet" href="../mystyle.css">
</head>


<body>
    <div id="content">
        <?php include '../header.php'; ?>
        <div id="wrapper">
            <h1>Delete an item</h1>

            <?php
            include '../functions/db_connect.php';

            $id=$_GET['id'];
            $class=$_GET['class'];

            $db=db_connect();
            $sql = "UPDATE ".$class." SET Is_deleted=1 WHERE ID = $id;";
            db_query($db, $sql);
            echo 'Item deleted from database<br>';
            db_close($db);
            ?> 

        </div>
    </div>
    <?php include '../footer.php'; ?>
</body>
</html>