
<?php
include 'db_connect.php';
include $_SERVER['DOCUMENT_ROOT']."/Tylecote_collection/globals.php";

function display_details($id, $class)
{
    global $micrograph_features;
    //Definition of the fields displayed for each class of items
    $fields_array=array();
    if ($class=="object")
    {
            $fields_list="ID, Type, Description, Material, Site, County, Country, Date_strati, Date_typo, Site_period, Site_layer, Museum, Museum_nb, Field_nb, Catalogue_nb, Weight, Lenght, Width, Thickness, Base_diameter, Max_diameter, Photo, Drawing, Card_scan_front, Card_scan_back, Comment, Date_added";
    }
    if ($class=="sample")
    {
            $fields_list="Sample_type, Sample_nb, Sample_material, Sample_condition, Date_sampled, Object_part, Section, Collection, Tylecote_notebook, Drawer, Date_repolished, Location_new_drawer, Location_new_code, Photo, Drawing, Comment, Date_added";
    }
    if ($class=="publication")
    {
            $fields_list="Author, Date, Title, Journal, Volume, Issue, Book_title, Editor, City, Publisher, Oxf_location, Comment, Date_added";
    }
    if ($class=="metallography")
    {
        $fields_list="ID, Object_part, Technology, HV, HB, Report, Date_metallo, Analyst, Comment, Date_added";           
    }
    if ($class=="chemistry")
    {
            $fields_list="ID, Technique, Sampling_method, Nb_runs, Date_analysed, Lab, Object_condition, Object_part, Cu, Sn, Pb, Zn, Arsenic, Sb, Ag, Ni, Co, Bi, Fe, Au, C, Si, Mn, P, S, Cr, Ca, O, Cd, Al, Mg, K, Ti, Se, Cl, Comment, Date_added";
    }
    $fields_array=explode(", ", $fields_list);
    
    //Definition of special fields (images and chemical elements
    $array_images=array("Photo", "Drawing", "Card_scan_front", "Card_scan_back");
    $array_chemistry[1]=array("Cu", "Sn", "Pb", "Zn", "Arsenic", "Sb", "Ag", "Ni", "Co", "Bi", "Fe", "Au");
    $array_chemistry[2]=array("C", "Si", "Mn", "P", "S", "Cr", "Ca", "O", "Cd", "Al", "Mg", "K", "Ti", "Se", "Cl");
    
    //Connection to the database
    $db=db_connect();

    //Fetches the information for this item
    if($class=="metallography" || $class=="chemistry")
    {
        $sql = "SELECT ".$fields_list." FROM ".$class." WHERE ID_object=".$id." AND Is_deleted=0";
    }
    else
    {
        $sql = "SELECT ".$fields_list." FROM ".$class." WHERE ID=".$id." AND Is_deleted=0";
    }
    $result = db_query($db, $sql);
    while($data = db_fetch_assoc($result))
    {
        //Displays the illustrations
        echo"<div id='photo_display'>";
        if ($class=="metallography")
        {
            //Fetches all the info for each micrograph
            $sql = "SELECT micrograph.ID, File, Description, Magnification, Fig_nb, ID_sample, sample.Photo, ID_publication, Cu_structure, Fe_structure, Porosity, Corrosion, Inclusions, C_content, Author, Date FROM micrograph
                 LEFT JOIN sample ON sample.ID=micrograph.ID_sample
                 LEFT JOIN publication ON publication.ID=micrograph.ID_publication
                 WHERE ID_metallography=".$data['ID']." AND micrograph.Is_deleted=0";
            $result2 = db_query($db, $sql);
            while($data2 = db_fetch_assoc($result2))
            {
                if(isset($data2['File']) && $data2['File']!='')
                {
                    $image_size=getimagesize("upload/micrograph/File/".$data2['File']);
                    echo"<IMG SRC='upload/micrograph/File/".$data2['File']."' ALT='' TITLE='".$data2['File']."' style='max-width:100%; max-height:250px;' /><br>";
                    if($data2['ID_publication']!=0 || $data2['Fig_nb']!='' || $data2['Magnification']!='' || $data2['Description']!='' || $data2['ID_sample']!=0)
                    {
                        echo"<table class='micrograph'>";
                        //echo"<tr><th>Publication</th><th>Figure</th><th>Magnification</th><th>Description</th><th>Sample</th></tr>";
                        echo"<tr><td onmouseover='ChangeColor(this, true)' onmouseout='ChangeColor(this, false)' onclick=DoNav('/Tylecote_collection/detailed_view.php?id=".$data2['ID_publication']."&class=publication');>".$data2['Author'].", ".$data2['Date']."</td>";
                        echo"<td>".$data2['Fig_nb']."</td><td>".$data2['Magnification']."</td><td>".$data2['Description']."</td>";
                        if(isset($data2['Photo']) && $data2['Photo']!='')
                        {
                            $sample_image_size=getimagesize("upload/sample/Photo/".$data2['Photo']);
                            echo"<td onmouseover='ChangeColor(this, true)' onmouseout='ChangeColor(this, false)' onclick=DoNav('/Tylecote_collection/detailed_view.php?id=".$data2['ID_sample']."&class=sample&action=link');><IMG SRC='upload/sample/Photo/".$data2['Photo']."' ALT='No image' TITLE='Image'".($sample_image_size[0]>$sample_image_size[1]?"width='60'":"height='60'")."></td></tr>";
                        }
                        echo"</tr>";
                        echo"</table><br>";
                        echo"<table class='micrograph'>";
                        foreach ($micrograph_features as $key=>$array)
                        {
                            if(!empty($data2[$key]))
                            {
                                echo "<tr><th>".$key."</th><td>".$data2[$key]."</td></tr>";
                            }
                        }
                        echo"</table>";
                    }
                    
                    //Displays the buttons to modify and delete the micrographs and their information
                    if(isset($_SESSION['access']) && $_SESSION['access']>1)
                    {
                        echo"<input type='button' name='goto_modify' value='Modify' onclick='self.location.href=\"writer/modify.php?id=".$data2["ID"]."&class=micrograph\"'>";
                        echo"<form method='post' enctype='multipart/form-data' class='form' action ='writer/delete.php?id=".$data2["ID"]." &class=micrograph' onsubmit='return confirm_delete(".$data2["ID"].")'>";
                        echo"<input type='submit' value='Delete''/>";
                        echo"</form>";
                    }
                    echo"<br><br>";
                }
            }
        }
        else //if item is not a metallography
        {
            //Display all the images
            foreach($array_images as $key=>$image)
            {
                if(isset($data["$image"]) && $data["$image"]!='')
                {	
                    $image_size=getimagesize("upload/".$class."/".$image."/".$data["$image"]);
                    echo"<IMG SRC='upload/".$class."/".$image."/".$data["$image"]."' ALT='' TITLE='".$image."' style='max-width:100%; max-height:250px;' /><br><br>";
                }
            }
        }
        echo"</div>";

        //Displays all the text information on the item
        echo"<table border=1 cellspacing=0 cellpadding=3 class='fiche'>";
        foreach ($fields_array as $key =>$field)
        {
            if ($field!="ID" && !in_array($field, $array_images) && !in_array($field, $array_chemistry[1]) && !in_array($field, $array_chemistry[2]) && $field!="Date_added" && $field!="ID_sample")
            {
                //nl2br function allows to disply the linebreaks as entered by user
                echo nl2br("<tr><th>".$field."</th><td>".$data["$field"]."</td></tr>");
            }
        }
        echo"</table>";
        
        //Displays the horizontal tables for the chemical composition
        if ($class=="chemistry")
        {
            for($i=1; $i<=2; $i++)
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
                        echo "<td>".$data["$field"]."</td>";
                }
                echo"</tr>";
                echo"</table>";
            }
            //Displays the key of the chemical composition table
            echo"<br>nd = not detected<br> bdl = below detection limit<br> empty cell = element wasn't sought for<br><br>";
        }
        
        //Displays the info of the addition to the database
        echo"<div id=db_entered_info>";
        echo"Added to database on: ".$data['Date_added'];
        echo"</div>";
        
        //Displays the buttons to modify or delete the metallographies and chemistries and enter metallography
        if(($class=="metallography" || $class=="chemistry") && isset($_SESSION['access']) && $_SESSION['access']>1)
        {
            echo"<br>";
            echo "<input type='button' name='goto_modify' value='Modify this ".$class."' onclick='self.location.href=\"writer/modify.php?id=".$data["ID"]."&class=".$class."\"'><br><br>";
            if($class=="metallography")
            {
                echo "<input type='button' name='add_micrograph' value='Add micrograph for this metallography' onclick='self.location.href=\"writer/insert_micrograph.php?id=".$id."&id_metallo=".$data["ID"]."\"'><br><br>";
            }
            echo"<form method='post' enctype='multipart/form-data' class='form' action ='writer/delete.php?id=".$data["ID"]." &class=".$class."' onsubmit='return confirm_delete(".$data["ID"].")'>";
            echo"<input type='submit' value='Delete this ".$class." from database''/>";
            echo"</form>";
        }
        echo"<br><br>";
    }
    
    //Close connection to database
    db_close($db);
}
?>