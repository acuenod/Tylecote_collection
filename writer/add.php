<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Insert new</title>
<link rel="stylesheet" href="../mystyle.css">
</head>

<body>
    <div id="content">
        <?php include '../header.php'; ?>
        <div id="wrapper">
            <h1>Insert a new item</h1>
            <?php
            include 'functions/get_values.php';
            include 'functions/photo_upload.php';
            include '../functions/db_connect.php';
            
            //print_r($_POST);
            $class=$_POST['class'];

            photo_upload($_FILES, $class);
            get_values($_POST, $_FILES);
            
            //Definition of the fields to be inserted in the database for each class of item
            if($class=="object")
            {
               $fields_list="Type, Description, Material, Site, County, Country, Date_strati, Date_typo, Site_period, Site_layer, Museum, Museum_nb, Field_nb, Catalogue_nb, Weight, Lenght, Width, Thickness, Base_diameter, Max_diameter, Photo, Drawing, Card_scan_front, Card_scan_back, Comment";
            }
            elseif($class=="sample")
            {
                $fields_list="Sample_type, Sample_nb, Sample_material, Sample_condition, Date_sampled, Object_part, Section, Collection, Tylecote_notebook, Drawer, Photo, Drawing, Comment";
            }
            elseif($class=="publication")
            {
                $fields_list="Author, Date, Title, Journal, Volume, Issue, Pages, Book_title, Editor, City, Publisher, Oxf_location, Comment";
            }
            elseif($class=="metallography")
            {
                $fields_list="ID_object, Object_part, Technology, HV, HB, Report, Date_metallo, Analyst, Comment";
            }
            elseif($class=="chemistry")
            {
                $fields_list="ID_object, Technique, Sampling_method, Nb_runs, Date_analysed, Lab, Object_condition, Object_part, Cu, Sn, Pb, Zn, Arsenic, Sb, Ag, Ni, Co, Bi, Fe, Au, C, Si, Mn, P, S, Cr, Ca, O, Cd, Al, Mg, K, Ti, Se, Cl, Comment";
            }
            elseif ($class=="micrograph")
            {
                $fields_list="ID_metallography, File, Description, Magnification, Fig_nb, ID_sample, ID_publication, Cu_structure, Fe_structure, Porosity, Corrosion, Inclusions, C_content";
            }
            $fields_array=explode(", ", $fields_list);
            $values_list="";
            foreach($fields_array as $field)
            {
                $value=$$field;
                $values_list=$values_list.", '".$value."'";
            }

            //Inserts the information on the item in the database
            //At the moment no checks are performed on the fields entered
            $db=db_connect();
            $sql = "INSERT INTO ".$class."(ID, ".$fields_list.") VALUES(''".$values_list.")";
            db_query($db, $sql);
            
            //Inserts the relationship between sample and object in the sample_object table if there is one
            $id = mysqli_insert_id($db);
            if($class=='object' && isset($_POST['ID_sample']))
            {
                $sql = "INSERT INTO sample_object (ID_sample, ID_object) VALUES (".$_POST['ID_sample'].", ".$id.")";
                db_query($db, $sql);
            }
            if($class=='sample' && isset($_POST['ID_object']))
            {
                $sql = "INSERT INTO sample_object (ID_sample, ID_object) VALUES (".$id.", ".$_POST['ID_object'].")";
                db_query($db, $sql);
            }
            
            //Inserts the ID of a chosen metallography for the summary of the technology into the object table
            if($class == 'metallography' && $Use_techno=="yes")
            {
                $sql="UPDATE object SET ID_metallo_techno=$id WHERE ID=".$ID_object;
                db_query($db, $sql);
            }
            
            //Display success
            echo 'Item added to database<br>';
            
            db_close($db);
            
            //Displays the buttons to either see the item or add a new one
            echo '<br><br>';
            if ($class=="metallography" || $class=="chemistry" || $class=="micrograph")
            {
                //For these classes we go back to displaying the object they are linked to, rather than the item
                echo "<input type='button' name='goto_fiche' value='See this object' onclick='self.location.href=\"../detailed_view.php?id=".$ID_object."&class=object&action=add\"'>";
            }
            else 
            {
                echo"<form method='post' action='insert_".$class.".php' enctype='multipart/form-data' class='form'>";
                echo"<input type='submit' value='Add new item' />";
                echo"</form>";
                echo "<input type='button' name='goto_fiche' value='See this item' onclick='self.location.href=\"../detailed_view.php?id=".$id."&class=".$class."&action=add\"'>";
            }
            ?>

        </div>
    </div>
<?php include '../footer.php'; ?>
</body>
</html> 