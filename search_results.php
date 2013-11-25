<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Search results</title>
<link rel="stylesheet" href="mystyle.css">
</head>


<body>
    <div id="content">
        <?php include 'header.php'; ?>
        <div id="wrapper">
            <h1>Search results</h1>
            Your results are displayed in four categories of entries: Objects, Samples, Publications and Micrographs.<br>
            Scroll down to see all categories.<br>
            Click on a line to see more detail on a particular search result.<br>
            
            <?php 
            include 'functions/db_connect.php';
            include 'functions/search_functions.php';
            include 'functions/display_table.php';

            /*Currently this search tool interprets blank spaces in the research string as "AND".
             * For each one of the entered terms it finds the preferred term (PT) if there is one, 
             * it then finds the narrower terms (NT) for both the original string and the PT and then the NTs of the NTs, etc. until we reach the leaves of the tree
             * it then finds the related terms (RT) for both the original search and its PT
             * finally, it searches for all of these terms (the original string, the PT, the NTs and the RTs) matching strings in the some of the fields (defined in $field_list) of the object, sample, publication and micrograph tables
             */

            $db=db_connect();

            if(isset($_POST['search_text'])) //If we come directly from a search
                $search_text=$_POST['search_text'];
            elseif(isset($_GET['search_text'])) //If we are back to the search results after having displayed the details of a record
                $search_text=str_replace("_", " ", $_GET['search_text']);
            
            $related_terms=search_related_terms($search_text);

            //The search is performed within objects, samples and publications
            $array_classes=array('object', 'sample', 'publication', 'micrograph');
            
            //Definition of the info to be displayed (= the fields that are searched) for each of these 3 classes of items
            foreach($array_classes as $class)
            {
                echo"<br><br><h3>".$class."s</h3><br>";
                if ($class=="object" && isset($_SESSION['access']))
                {
                    $fields_list="Type, Material, Site, Date_strati, Date_typo, Museum_nb, Field_nb, Catalogue_nb, Photo, Drawing";
                }
                elseif ($class=="object")
                {
                    $fields_list="Type, Material, Site, Date_strati, Date_typo, Museum_nb, Field_nb, Catalogue_nb";
                }
                elseif ($class=="sample")
                {
                    $fields_list="Sample_type, Sample_nb, Sample_material, Object_part, Photo";
                }
                elseif ($class=="publication")
                {
                    $fields_list="Author, Date, Title, Publisher, City, Journal, Volume, Issue, Pages, Editor, Book_title, Oxf_location, Comment";
                }
                elseif ($class =="micrograph")
                {
                    $fields_list="ID_metallography, File, Description, Cu_structure, Fe_structure, Porosity, Corrosion, Inclusions, C_content";
                }
                $fields_array=explode(", ", $fields_list);
                $detailed_fields_array=array(); //names of the fields in the table.field format
                foreach ($fields_array as $field)
                {
                    $detailed_fields_array[]=$class.".".$field;
                }
                /*if ($class=="object") //If we want to also display and search the sample_number for the objects
                {
                    $fields_list=$fields_list.", Sample_nb";
                    $fields_array[]="Sample_nb";
                    $detailed_fields_array[]="sample.Sample_nb";
                }*/
                if ($class == 'micrograph')
                {
                    $fields_list=$fields_list.", ID_object";
                    $fields_array[]="ID_object";
                    $detailed_fields_array[]="metallography.ID_object";
                }
                $detailed_fields_list=implode(", ", $detailed_fields_array);

                //Definition of the WHERE clause of the final SQL request
                $clause_final=write_where_clause($related_terms, $detailed_fields_array);
                
                /*if($class=="object")  //If we want to also display and search the sample_number for the objects
                {
                    $table=$class." JOIN sample_object ON object.ID = sample_object.ID_object JOIN sample ON ID_sample = sample.ID";
                }
                else*/
                
                $table=$class;
                if($class=="micrograph")
                {
                    $table=$table." JOIN metallography on micrograph.ID_metallography=metallography.ID";
                }

                //Displays the number items found
                $sql="SELECT count(*) FROM ".$table." WHERE ".$class.".Is_deleted=0 AND (".$clause_final.")";
                $result = db_query($db, $sql);
                $numrows = db_fetch_row($result);
                echo "Your search for <b>".$search_text."</b> returned <b>".$numrows[0]." ". $class."s</b>.<br>";

                //Displays the table of results
                $sql = "SELECT ".$class.".ID, ".$detailed_fields_list." FROM ".$table." WHERE ".$class.".Is_deleted=0 AND (".$clause_final.")";
                display_table($db, $sql, $fields_array, $class, false, 0, "search", 0, $search_text);
            }
            
            db_close($db);
            ?>
            <br><br>
        </div>
    </div>
<?php include 'footer.php'; ?>
</body>
</html> 
