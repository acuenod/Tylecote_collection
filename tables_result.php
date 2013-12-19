<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Tables</title>
<link rel="stylesheet" href="mystyle.css">
<script src='/Tylecote_collection/functions/navigation.js'></script>
</head>



<body>
    <div id="content">
        <?php include 'header.php'; ?>
        <div id="wrapper">
            <h1>Table</h1>
            <div id="wide_table">
            <?php
            /*This page searches the database for objects corresponding the search_terms chosen by the user in
             *  the first part of the tables_choices.php form.
             * It then loops through the results and searches the database for more information linked to these
             *  objects in the samples, publications, metallography and micrograph tables, depending on what the
             *  user has asked to be displayed in the second part of the tables_choices.php form.
             * If the user has asked for information on the micrographs it loops through the metallographies of
             *  a given object and finds all the corresponding micrographs.
             * The results are than displayed in an html table.
             */
            
            
            include 'functions/db_connect.php';
            include 'functions/search_functions.php';
            include 'functions/tables_functions.php';
            include 'globals.php';
            
            $db=db_connect();
            global $field_title;
                
            //Definition of the where clause for the search of the objects corresponding to the request
            $clause= tables_where_clause($_POST['search_text'], $_POST['search_field'], $_POST['operator']);
            
            //Definition of the table for the search of the objects corresponding to the request
            $table="object LEFT JOIN sample_object ON object.ID = sample_object.ID_object LEFT JOIN sample ON ID_sample = sample.ID
                           LEFT JOIN object_publication ON object.ID = object_publication.ID_object LEFT JOIN publication ON ID_publication = publication.ID ";
            //$table="object";
            //Definition of the correspondance between the selected info to be displayed and the fields in the tables
            $correspondance=define_fields($_POST);
            $display_fields=$correspondance['simple_fields'];
            $display_detailed_fields=$correspondance['detailed_fields'];
            
            //Transformation of the array of fields to be displayed to a list for the SQL request
            foreach($display_detailed_fields as $class=>$array)
            {    
                $fields_list[$class]=implode(", ", $array);
                if($fields_list[$class]=="")
                {
                    $fields_list[$class]=$class.".ID";
                }
                else
                {
                    $fields_list[$class]=$class.".ID, ".$fields_list[$class];
                }
            }
            
            //Starts the search and displays the results in a table
            if(isset($fields_list['object']))
            {
                //Display the table headers using the global variable $field_title to translate between field name and explicite column header
                echo"<table id='mytable' class='normal' overflow='scroll'>";
                echo"<thead><tr>";
                foreach($display_fields as $class=> $array)
                {
                    foreach($array as $field)
                    {
                        echo"<th>".$field_title[$field]."</th>";
                    }
                }
                echo"</tr></thead>";
                echo"<tbody>";
                
                //Finds all the results in the object table. For each found result finds the samples, publications, metallo and chemistry linked to this object
                $sql="SELECT DISTINCT ".$fields_list['object']." FROM ".$table." WHERE object.Is_deleted=0 AND (".$clause.")";
                $result = db_query($db, $sql);
                while($data= db_fetch_assoc($result))
                {
                    //Concatenation of the Identification fields (Museum_nb, Field_nb, Catalogue_nb) into a single field separated with "/"
                    if(in_array("Identification", $display_fields['object']))
                    {
                        $data['Identification']=implode(" /<br>", array_filter(array($data['Museum_nb'], $data['Field_nb'], $data['Catalogue_nb'])));
                    }
                    //Deals with the image fields
                    if(in_array("Image", $display_fields['object']))
                    {
                        $data['Image']=  define_image_html($data);
                    }
                    
                    //Get the info related to this object in all of the other tables (sample, publication, metallography and chemistry) 
                    if(isset($display_fields['sample']) || isset($display_fields['publication']) || isset($display_fields['metallography']) || isset($display_fields['chemistry']))
                    {
                        $linked_data=get_linked_data($data['ID'], $display_fields, $fields_list);
                        $rows=$linked_data['rows'];
                        $numrows=$linked_data['numrows'];
                    }
                    
                    //Display of the rows of the table
                    if(isset($rows)) //If the user is asking for more than just information on the object
                    {
                        //Defines the number of rows to be merged
                        if(max($numrows)>0)
                        {
                            $max_rows=max($numrows);
                        }
                        else    $max_rows=1;
                        //Display the row with change of colour on hover and link to the item on click.
                        echo"<tr onmouseover='ChangeColor(this, true)' onmouseout='ChangeColor(this, false)'>";
                        foreach($display_fields['object'] as $field)
                        {
                            echo"<td rowspan=".$max_rows." onclick=DoNav('/Tylecote_collection/detailed_view.php?id=".$data['ID']."&class=object&action=tables')>".$data[$field]."</td>";
                        }
                        $i=0;
                        while($i<$max_rows)
                        {
                            if($i!=0)
                            {
                                echo"<tr>";
                            }
                            foreach($display_fields as $class=>$array)
                            {
                                if($class!='object')
                                {
                                    foreach($array as $field)
                                    {
                                        echo"<td>";
                                        if(isset($rows[$class][$i]))
                                        {
                                            echo $rows[$class][$i][$field];
                                        }
                                        echo"</td>";
                                    }   
                                }
                            }
                            echo"</tr>";
                            $i++;
                        }
                    }
                    else //If there is only information on the object (no need to add a rowspan)
                    {
                        echo"<tr onmouseover='ChangeColor(this, true)' onmouseout='ChangeColor(this, false)'>";
                        foreach($display_fields['object'] as $field)
                        {
                            echo"<td onclick=DoNav('/Tylecote_collection/detailed_view.php?id=".$data['ID']."&class=object&action=tables')>".$data[$field]."</td>";
                        }
                        echo"</tr>";
                    }
                }
                echo"</tbody></table>";
                echo"</div>";
                echo"<br>";
            }
            
            //Submits the information form the tables_choice.php form to the export page 
            //The export will redo all the work and write it in an excel rather than a html table
            echo"<form method='post' action='tables_export.php'>";
            foreach($_POST as $key=>$array)
            {
                echo"<input type='hidden' name='".$key."' value=".serialize($array).">";
            }
            echo"<input type='submit' value='Export table to Excel'>";
            
            db_close($db);
            ?>
            
        </div>
    </div>
<?php include 'footer.php'; ?>
</body>
</html> 

