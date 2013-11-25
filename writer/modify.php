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
            <h2>Item details</h2>
            
            <?php
            include '../functions/db_connect.php';
            include '../functions/display_linked.php';
            include '../globals.php';
            global $micrograph_features;
            global $field_title;
            global $array_chemistry;
            
            $id=$_GET['id'];
            $class=$_GET['class'];
            
            //Definition of the fields to be displayed for each class of items
            $fields_array=array();
            if ($class=="object")
            {
                $fields_list="Type, Description, Material, Site, County, Country, Date_strati, Date_typo, Site_period, Site_layer, Museum, Museum_nb, Field_nb, Catalogue_nb, Weight, Lenght, Width, Thickness, Base_diameter, Max_diameter, Photo, Drawing, Card_scan_front, Card_scan_back, Comment";
            }
            elseif ($class=="sample")
            {
                $fields_list="Sample_type, Sample_nb, Sample_material, Sample_condition, Date_sampled, Object_part, Section, Collection, Tylecote_notebook, Drawer, Date_repolished, Location_new_drawer, Location_new_code, Photo, Drawing, Comment";
            }
            elseif ($class=="publication")
            {
                $fields_list="Author, Date, Title, Journal, Volume, Issue, Pages, Book_title, Editor, City, Publisher, Oxf_location, Pdf, Comment";
            }
            elseif ($class=="metallography")
            {
                $fields_list="ID, ID_object, Object_part, Technology, HV, HB, Report, Date_metallo, Analyst, Comment";
            }
            elseif ($class=="chemistry")
            {
                $fields_list="ID_object, Technique, Sampling_method, Nb_runs, Date_analysed, Lab, Object_condition, Object_part, Cu, Sn, Pb, Zn, Arsenic, Sb, Ag, Ni, Co, Bi, Fe, Au, C, Si, Mn, P, S, Cr, Ca, O, Cd, Al, Mg, K, Ti, Se, Cl, SiO2, FeO, MnO, BaO, P2O5, CaO, Al2O3, K2O, MgO, TiO2, SO3, Na2O, V2O5, Comment";
            }
            elseif ($class=="micrograph")
            {
                $fields_list="File, Is_public, Description, Magnification, Fig_nb, ID_sample, ID_publication, ID_object, Cu_structure, Fe_structure, Porosity, Corrosion, Inclusions, C_content";
            }
            $fields_array=explode(", ", $fields_list);
            
            //For micrographs we also want to get ID_object which is in the metallography table
            if ($class=="micrograph")
            {
                $join="LEFT JOIN metallography ON metallography.ID=micrograph.ID_metallography";
            }
            else $join="";
            
            $db=db_connect();
            
            $sql = "SELECT ". $fields_list." FROM ".$class." ".$join." WHERE ".$class.".ID=".$id;
            $result = db_query($db, $sql);
            $data = db_fetch_assoc($result);

            //Display the form
            echo"<form method='post' action='modify_db.php' enctype='multipart/form-data' class='form'>";
                echo"<input type='hidden' name='id' value=".$id." />";
                echo"<input type='hidden' name='class' value=".$class." />";
                foreach($fields_array as $field)
                {
                    //Display of normal text fields
                    if($field!="ID" && $field!="ID_object" && $field!="ID_sample" && $field!="ID_publication" && $field!="Photo" && $field!="Drawing" && $field!="Card_scan_front" && $field!="Card_scan_back" && $field!="File" && $field!="Is_public" && $field!="Pdf" && $field!="Description" && $field!="Comment" && $field!="Report" && $field!="Technology" && !in_array($field, array_keys($micrograph_features)) && !in_array($field, $array_chemistry[1]) && !in_array($field, $array_chemistry[2]) && !in_array($field, $array_chemistry[3]))
                    {
                        echo'<br>'.$field_title[$field].': <input type="text" name='.$field.' value="'.$data[$field].'"><br>';
                    }
                    //Display of images and files
                    elseif($field=="Photo" || $field=="Drawing" || $field=="Card_scan_front" || $field=="Card_scan_back" || $field=="Micrograph" || $field=="File" || $field=="Pdf")
                    {
                        echo'<br>Upload a new '.$field.': <input type="file" name="'.$field.'"/>';
                        if($field!="File")
                        {
                            echo'or <input type="checkbox" name="delete_'.$field.'" id="delete_'.$field.'" /> <label for="delete_'.$field.'">Delete previous '.$field.'</label>';
                        }
                        echo'<br />';
                    }
                    //Display of text areas
                    elseif($field=="Description" || $field=="Comment" || $field=="Report" || $field=="Technology")
                    {
                        echo'<br>'.$field.': <textarea name="'.$field.'" rows="5" cols="45">'.$data[$field].'</textarea> <br />';
                    }
                    
                    //Display of check box
                    elseif($field=='Is_public')
                    {
                        if ($data['Is_public']=="Y")
                        {
                            $checked_Y="checked";
                            $checked_N="";
                        }
                        else
                        {
                            $checked_Y="";
                            $checked_N="checked";
                        }
                        echo"<br>Should this image be made available for the general public to view?<br>";
                        echo"<input type=radio name='Is_public' value='Y' ".$checked_Y."/>Yes</br>";
                        echo"<input type=radio name='Is_public' value='N' ".$checked_N."/>No</br>";
                    }
                }
                //Display of chemistry blocks
                if ($class=="chemistry")
                {
                    for($i=1; $i<=3; $i++)
                    {
                        echo"<br>";
                        echo"<table border=1 cellspacing=0 cellpadding=3 class='normal'>";
                        echo"<tr>";
                        foreach ($array_chemistry[$i] as $field)
                        {
                            if ($field=="Arsenic") //Has to be done because "As" cannot be used as a column name as it has a particular meaning in SQL
                            {
                                echo "<th>%As</th>";
                            }
                            else
                            {
                                echo "<th>%".$field."</th>";
                            }
                        }
                        echo"</tr>";
                        echo"<tr>";
                        foreach ($array_chemistry[$i] as $field)
                        {
                                echo "<td><input type='text' name=".$field." value='".$data[$field]."' size='3'></td>";
                        }
                        echo"</tr>";
                        echo"</table>";
                    }
                }
                //For metallographies, we need to check if this metallography is the one selected for the description of the object.
                //If so the check-box will appear checked
                if($class=="metallography")
                {
                    $sql="SELECT ID_metallo_techno FROM object WHERE ID=".$data['ID_object']." AND Is_deleted=0";
                    $result = db_query($db, $sql);
                    $data2 = db_fetch_assoc($result);
                    if ($data2['ID_metallo_techno']==$data['ID'])
                    {
                        $box_status="checked='checked'";
                    }
                    else $box_status="";
                    echo"<input type=checkbox name='Use_techno' value='Yes' ".$box_status."/> Use this summary for the description of the object?</br>";
                }
                
                db_close($db);
                
                //Also passes ID_object in a hidden field !!what for?!!
                if($class=="metallography" || $class=="chemistry" || $class=="micrograph")
                {
                    echo"<input type='hidden' name='ID_object', value='".$data['ID_object']."'>";
                }
                
                //For micrographs, a choice of the the publications and samples linked to the objects are available to be linked to the micrograph
                //And a form is available for a description of the features seen in the micrograph
                if($class=="micrograph")
                {
                    display_linked($data['ID_object'], "object", "radio", $data['ID_publication'], $data['ID_sample']);
                    echo"<h3>Which of the following features are present?</h3>";
                    echo"<table><tr>";
                    foreach ($micrograph_features as $header=>$array_features)
                    {
                        echo'<th>'.$header.'</th>';
                    }
                    echo"</tr><tr>";
                    foreach ($micrograph_features as $header=>$array_features)
                    {
                        echo'<td>';
                        foreach ($array_features as $feature)
                        {
                            
                            if(strpos($data[$header], $feature)!==false)
                            {   
                                $box_status="checked='checked'";
                            }
                            else $box_status="";
                            if($feature != 'Percentage')
                            {
                                echo"<input type='checkbox' name='".$header."[]' value='".$feature."' ".$box_status.">".$feature."<br>";
                            }
                            else 
                            {
                                $array_C_content=explode(";", $data['C_content']);
                                array_pop($array_C_content);
                                echo "C percentage<input type='text' name='C_content[]' value='".end($array_C_content)."'";
                            }
                        }
                        echo'</td>';
                    }
                    echo"</tr></table>";
                }

                ?>

                <br />
                <input type="submit" value="Modify" />
                <br />

            </form>

        </div>
    </div>
<?php include '../footer.php'; ?>
</body>
</html> 