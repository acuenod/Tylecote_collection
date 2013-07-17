<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Modify item</title>
<link rel="stylesheet" href="../mystyle.css">
</head>


<body>
    <div id="content">
        <?php include '../header.php'; ?>
        <div id="wrapper">
        <h1>Modify an item</h1>
            <?php
            include '../functions/db_connect.php';
            include 'functions/get_values.php';
            include 'functions/photo_upload.php';

            $id=$_POST['id'];
            $class=$_POST['class'];

            photo_upload($_FILES, $class);
            get_values($_POST, $_FILES);

            //Definition of the fields to be updated for each class of item
            if($class=="object")
            {
                $fields_list="Type, Description, Material, Site, County, Country, Date_strati, Date_typo, Site_period, Site_layer, Museum, Museum_nb, Field_nb, Catalogue_nb, Weight, Lenght, Width, Thickness, Base_diameter, Max_diameter, Photo, Drawing, Card_scan_front, Card_scan_back, Comment";
            }
            elseif($class=="sample")
            {
                $fields_list="Sample_type, Sample_nb, Sample_material, Sample_condition, Date_sampled, Object_part, Section, Collection, Tylecote_notebook, Drawer, Date_repolished, Location_new_drawer, Location_new_code, Photo, Drawing, Comment";
            }
            elseif($class=="publication")
            {
                $fields_list="Author, Date, Title, Journal, Volume, Issue, Book_title, Editor, City, Publisher, Oxf_location, Comment";
            }
            elseif ($class=="metallography")
            {
                $fields_list="Object_part, HV, HB, Report, Date_metallo, Analyst, Comment";
            }
            elseif($class=="chemistry")
            {
                $fields_list="Technique, Sampling_method, Nb_runs, Date_analysed, Lab, Object_condition, Object_part, Cu, Sn, Pb, Zn, Arsenic, Sb, Ag, Ni, Co, Bi, Fe, Au, C, Si, Mn, P, S, Cr, Ca, O, Cd, Al, Mg, K, Ti, Se, Cl, Comment";
            }
            elseif ($class=="micrograph")
            {
                $fields_list="File, Description, Magnification, Fig_nb, ID_sample, ID_publication";
            }
            $fields_array=explode(", ", $fields_list);

            $db=db_connect();
            
            //Preparation of the SQL request to update the database
            $sql = "UPDATE ".$class." SET ";
            foreach($fields_array as $field)
            {
                //If not image fields and not the last field
                if($field!="ID_publication" && $field!="Photo" && $field!="Drawing" && $field!="Card_scan_front" && $field!="Card_scan_back" && $field!="File" && $field!="Comment")
                {
                    $sql=$sql.$field."='".$$field."', ";
                }
                //If last fields of the list  no comma afterwards
                elseif($field=="Comment" || $field=="ID_publication")
                {
                    $sql=$sql.$field."='".$$field."' ";
                }
            }
            $sql=$sql."WHERE ID = ".$id;
            
            //Update the database
            //At the moment, no checks are performed on the data entered
            db_query($db, $sql);

            //Definition of the image and files fields
            $array_illustrations=array("Photo", "Drawing", "Card_scan_front", "Card_scan_back", "File");
            
            //Update or delete the images and file fields
            foreach($array_illustrations as $field)
            {
                $delete="delete_".$field;
                if ($$field!="")
                {
                    $sql="UPDATE ".$class." SET ".$field."='".$$field."' WHERE ID = ".$id;
                    db_query($db, $sql);
                }
                elseif ($$delete=="yes")
                {
                    $sql="UPDATE ".$class." SET ".$field."='' WHERE ID = ".$id;
                    db_query($db, $sql);
                }
            }
            echo 'Item modified in database<br>';
            db_close($db);

            //Display of the buttons to either view this item or add another one
            echo '<br><br>';
            if($class=="metallography" || $class=="chemistry" || $class=="micrograph")
            {
                //For these classes we go back to displaying the object they are linked to, rather than the item
                echo "<input type='button' name='goto_fiche' value='See this item' onclick='self.location.href=\"../detailed_view.php?id=".$ID_object."&class=object&action=modify\"'>";
            }
            else
            {
                echo "<input type='button' name='add_new' value='Add new item' onclick='self.location.href=\"insert_".$class.".php\"'>";
                echo "<input type='button' name='goto_fiche' value='See this item' onclick='self.location.href=\"../detailed_view.php?id=".$id."&class=".$class."&action=modify\"'>";
            }
            ?>

        </div>
    </div>
<?php include '../footer.php'; ?>
</body>
</html> 