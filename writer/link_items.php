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
            
            <h2>Link objects and publications or samples</h2>
            
            Click on the box to the left of the object(s) to be linked and then on the boxes left of 
            the samples and/or publications they should be linked to.<br>
            Finally click on the link button at the bottom of the page.<br>
            <br>
            This page can take a while to load. Please be patient. <br>
            
            <?php
            include '../functions/db_connect.php';
            include '../functions/display_table.php';
            
            $db=db_connect();
            
            //Lengthen the timeout limit on the page to give it time to load all the tables
            set_time_limit(120);
            
            //Definition of the 3 classes of items we want to display
            $classes=array("object", "sample", "publication");
            
            //Definition of the fields to display for each class of item
            $fields_list=array();
            $fileds_array=array();
            $fields_list['object']="Type, Site, Date_strati, Museum_nb, Field_nb, Catalogue_nb, Photo, Drawing";
            $fields_list['sample']="Sample_type, Sample_nb, Sample_material, Photo";
            $fields_list['publication']="Author, Date, Title, Journal";
            foreach ($fields_list as $class=>$list)
            {
                $fields_array[$class]=explode(", ", $fields_list[$class]);
            }

            //Fetches the information for all objects, samples and publications in the database and order with most recently entered first
            foreach($classes as $key=>$class)
            {
                $sql[$class] = "SELECT ID, ".$fields_list[$class]." FROM ".$class." WHERE Is_deleted=0 ORDER BY ID DESC";
            }
            ?>
            
            <!--Displays three tables for all the objects (top), samples (bottom left) and publications (bottom right)-->
            <form method="post" action="link_result.php" enctype="multipart/form-data">
                <div id='wide'>
                    <h3>Objects</h3>
                    <?php display_table($db, $sql['object'], $fields_array['object'], "object", "check", 0, "link", 0); ?>
                    <br>
                </div>
                <br>
                <hr align='center' width='100%'>
                <div id='right'>
                    <h3>Publications</h3>
                    <?php display_table($db, $sql['publication'], $fields_array['publication'], "publication", "check", 0, "link", 0); ?>
                </div>
                <div id='left'>
                <h3>Samples</h3> 
                     <?php display_table($db, $sql['sample'], $fields_array['sample'], "sample", "check", 0, "link", 0);?>
                </div>
                <br>
                <input type='submit' value='Link '/>
            </form>
            
           <?php db_close($db);?>

        </div>
    </div>
<?php include '../footer.php'; ?>
</body>
</html> 