<?php

/*
** Function : get_values
** Input : tables post and files
** Output : none
** Description : gets the values stored in the _POST, _GET and _FILE tables, and store them in global variables. If they don't exist, it stores an empty chain in the variables.
** Creator : Aurelie
** Date : 9 April 2010
*/


function get_values($post, $files)
{
    include $_SERVER['DOCUMENT_ROOT']."/Tylecote_collection/globals.php";
    $db=db_connect();
    global $Type, $Description, $Material, $Site, $County, $Country, $Date_strati, $Date_typo, $Site_period, $Site_layer, $Museum, $Museum_nb, $Field_nb, $Catalogue_nb, $Weight, $Lenght, $Width, $Thickness, $Base_diameter, $Max_diameter, $Photo, $Drawing, $Card_scan_front, $Card_scan_back, $Comment;
    global $Sample_type, $Sample_nb, $Sample_material, $Sample_condition, $Date_sampled, $Object_part, $Section, $Collection, $Tylecote_notebook, $Drawer, $Date_repolished, $Location_new_drawer, $Location_new_code, $Photo, $Drawing, $Date_analysed, $Comment;
    global $Author, $Date, $Title, $Journal, $Volume, $Issue, $Book_title, $Editor, $City, $Publisher, $Oxf_location, $Comment;
    global $ID_object, $ID_sample, $Object_part, $Technology, $Use_techno, $HV, $HB, $Report, $Date_metallo, $Analyst, $Comment;
    global $ID_object, $Technique, $Sampling_method, $Nb_runs, $Date_analysed, $Lab, $Object_condition, $Object_part, $Cu, $Sn, $Pb, $Zn, $Arsenic, $Sb, $Ag, $Ni, $Co, $Bi, $Fe, $Au, $C, $Si, $Mn, $P, $S, $Cr, $Ca, $O, $Cd, $Al, $Mg, $K, $Ti, $Se, $Cl, $Comment;
    global $ID_metallography, $File, $Description, $Magnification, $Fig_nb, $ID_sample, $ID_publication, $Cu_structure, $Fe_structure, $Porosity, $Corrosion, $Inclusions, $C_content;
    global $delete_Photo, $delete_Drawing, $delete_Card_scan_front, $delete_Card_scan_back, $delete_File;
   
    if($post['class']=="object")
    {
            $fields_list="Type, Description, Material, Site, County, Country, Date_strati, Date_typo, Site_period, Site_layer, Museum, Museum_nb, Field_nb, Catalogue_nb, Weight, Lenght, Width, Thickness, Base_diameter, Max_diameter, Photo, Drawing, Card_scan_front, Card_scan_back, Comment";
    }
    elseif($post['class']=="sample")
    {
            $fields_list="Sample_type, Sample_nb, Sample_material, Sample_condition, Date_sampled, Object_part, Section, Collection, Tylecote_notebook, Drawer, Date_repolished, Location_new_drawer, Location_new_code, Photo, Drawing, Comment";
    }
    elseif($post['class']=="publication")
    {
            $fields_list="Author, Date, Title, Journal, Volume, Issue, Book_title, Editor, City, Publisher, Oxf_location, Comment";
    }
    elseif($post['class']=="metallography")
    {
            $fields_list="ID_object, ID_sample, Object_part, Technology, Use_techno, HV, HB, Report, Date_metallo, Analyst, Micrograph, Img_2, Img_3, Comment";
    }
    elseif($post['class']=="chemistry")
    {
            $fields_list="ID_object, Technique, Sampling_method, Nb_runs, Date_analysed, Lab, Object_condition, Object_part, Cu, Sn, Pb, Zn, Arsenic, Sb, Ag, Ni, Co, Bi, Fe, Au, C, Si, Mn, P, S, Cr, Ca, O, Cd, Al, Mg, K, Ti, Se, Cl, Comment";
    }
    elseif($post['class']=="micrograph")
    {
            $fields_list="ID_metallography, ID_object, File, Description, Magnification, Fig_nb, ID_sample, ID_publication";
    }
    $fields_array=explode(", ", $fields_list);

    foreach($fields_array as $key => $field)
    {
            if(isset($post["$field"]))      $$field=mysqli_real_escape_string($db, $post["$field"]);
            else    $$field="";
    }
    if($post['class']=="micrograph")
    {
        foreach($micrograph_features as $header=>$array_features)
        {
            $$header="";
            if(isset($post["$header"]))
            {
                foreach($post["$header"] as $feature)
                {
                    if($feature!="")  //necessary because if the percentage of C is left black, C_content will have an empty value
                    {
                        $$header=$$header.mysqli_real_escape_string($db, $feature)."; ";
                    }
                }
            }
        }
    }
    
    if(isset($files['Photo']['name']))      $Photo=$files['Photo']['name'];
    else      $Photo="";
    if(isset($files['Drawing']['name']))      $Drawing=$files['Drawing']['name'];
    else      $Drawing="";
    if(isset($files['Card_scan_front']['name']))      $Card_scan_front=$files['Card_scan_front']['name'];
    else      $Card_scan_front="";
    if(isset($files['Card_scan_back']['name']))      $Card_scan_back=$files['Card_scan_back']['name'];
    else      $Card_scan_back="";
    if(isset($files['File']['name']))      $File=$files['File']['name'];
    else      $File="";

    if(isset($post['delete_Photo']))      $delete_Photo="yes";
    else      $delete_Photo="no";
    if(isset($post['delete_Drawing']))      $delete_Drawing="yes";
    else      $delete_Drawing="no";
    if(isset($post['delete_Card_scan_front']))      $delete_Card_scan_front="yes";
    else      $delete_Card_scan_front="no";
    if(isset($post['delete_Card_scan_back']))      $delete_Card_scan_back="yes";
    else      $delete_Card_scan_back="no";
    if(isset($post['delete_File']))      $delete_File="yes";
    else      $delete_File="no";

    db_close($db);
}

?> 