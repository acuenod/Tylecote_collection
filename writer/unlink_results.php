<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Link items</title>
<link rel="stylesheet" href="../mystyle.css">
</head>


<body>
    <div id="content">
        <?php include '../header.php'; ?>
        <div id="wrapper">

            <h1>Unlink items</h1>


            <?php
            include '../functions/db_connect.php';
            
            $post=$_POST;
            ${"id_".$post['class_element']}=$post['ID_element'];
            ${"id_".$post['class_linked']}=$post['ID_linked'];
            
            $db=db_connect();
            if(isset($id_sample))
            {
                $sql="DELETE FROM sample_object WHERE ID_sample=$id_sample AND ID_object=$id_object";
            }
            if(isset($id_publication))
            {
                $sql="DELETE FROM object_publication WHERE ID_object=$id_object AND ID_publication=$id_publication";
            }
            db_query($db, $sql);
            db_close($db);
            
            echo"Items successfully unlinked."
            ?>

        </div>
    </div>
<?php include '../footer.php'; ?>
</body>
</html> 