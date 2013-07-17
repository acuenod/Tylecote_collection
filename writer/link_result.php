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

            <h1>Link items</h1>


            <?php
            include '../functions/db_connect.php';
            
            $post=$_POST;
            
            $db=db_connect();

            //Links objects and publications
            if(isset($post['ID_object']) && isset($post['ID_publication']) && !empty($post['ID_object']) && !empty($post['ID_publication']))
            {
                foreach ($post['ID_object'] as $key=>$id_object)
                {
                    foreach ($post['ID_publication'] as $key=>$id_publication)
                    {
                        $sql="INSERT IGNORE INTO object_publication (ID_object, ID_publication) VALUES (".$id_object.", ".$id_publication.")";
                        db_query($db, $sql);
                    }
                }
                echo"Objects and publications successfully linked.<br>";
            }
            
            //Links objects and samples
            if(isset($post['ID_object']) && isset($post['ID_sample']) && !empty($post['ID_object']) && !empty($post['ID_sample']))
            {
                foreach ($post['ID_object'] as $key=>$id_object)
                {
                    foreach ($post['ID_sample'] as $key=>$id_sample)
                    {
                        $sql="INSERT IGNORE INTO sample_object (ID_sample, ID_object) VALUES (".$id_sample.", ".$id_object.")";
                        db_query($db, $sql);
                    }
                }
                echo"Objects and samples successfully linked.<br>";
            }
            
            db_close($db);

            ?>

        </div>
    </div>
<?php include '../footer.php'; ?>
</body>
</html> 