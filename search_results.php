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
            Click on a line to see more detail <br><br>
            <?php 
            include 'functions/db_connect.php';
            include 'functions/display_table.php';

            /*Currently this search tool interprets blank spaces in the research string as "AND".
             * For each one of the entered terms it finds the preferred term (PT) if there is one, 
             * it then finds the narrower terms (NT) for both the original string and the PT and then the NTs of the NTs, etc. until we reach the leaves of the tree
             * it then finds the related terms (RT) for both the original search and its PT
             * finally, it searches for all of these terms (the original string, the PT, the NTs and the RTs) matching strings in the some of the fields (defined in $filed_list) of the object, sample, publication and micrograph tables
             */

            $db=db_connect();

            if(isset($_POST['search_text'])) //If we come directly from a search
                $search_text=$_POST['search_text'];
            elseif(isset($_GET['search_text'])) //If we are back to the search results after having displayed the details of a record
                $search_text=str_replace("_", " ", $_GET['search_text']);
            
            //Puts the search chain and then each word of this chain seperately in the "$search" array.
            if(count(explode(" ", $search_text))==1)
            {
                $search[0]=$search_text;
            }
            else
            {
                $search=array_merge(array($search_text), explode(" ", $search_text));
            }

            //For each one of these terms, starts an array of this term (cleaned up and allowing for different spelling, plurals, etc.) and related terms 
            $related_terms=array();
            foreach($search as $key=>$search_term)
            {
                $search_term = strtoupper($search_term); //changes string in all upper case 
                $search_term = strip_tags($search_term); //print_r($search_term); echo"<br>";//strips NUL bytes, HTML and PHP tags ex: <p>
                $search_term = trim ($search_term); //whitespaces (blank, tab, return..) stripped from the beginning and end of string
                $pattern=array('/OU?/', '/VES$/', '/IES$/', '/ES$/', '/S$/', '/AE/');
                $replacement=array('OU?', '(VES?|FE)', '(IES?|Y)', 'E?S?', 'S?', 'AE?');
                $search_term = preg_replace($pattern, $replacement, $search_term); // regex. replaces plural endings by singular or plural and o and ou by o or ou (for words like colour)
                $search_term = mysqli_real_escape_string($db, $search_term); //escapes certain characters (ex: ') to make it a valid SQL sring usable in SQL statements.
                $related_terms[$search_term]=array();
                $related_terms[$search_term][]=$search_term;

                //Find the preferred term if the research term isn't one.
                $sql = "SELECT T2.Term 
                    FROM thesaurus_term AS T2 
                    INNER JOIN thesaurus_relationship AS R ON T2.ID = R.ID_term2 
                    INNER JOIN thesaurus_term AS T1 ON T1.ID = R.ID_term1 
                    WHERE upper(T1.Term) REGEXP '[[:<:]]".$search_term."[[:>:]]' AND T1.Is_deleted=0 AND T2.Is_deleted=0 AND R.Is_deleted=0 
                        AND (R.Relationship='Use')";
                $result = db_query($db, $sql);
                $data=db_fetch_assoc($result);
                if(!empty($data))
                {
                    $preferred_term[$search_term]=strtoupper($data['Term']);
                }
                else
                {
                    $sql = "SELECT T2.Term 
                    FROM thesaurus_term AS T2 
                    INNER JOIN thesaurus_relationship AS R ON T2.ID = R.ID_term1 
                    INNER JOIN thesaurus_term AS T1 ON T1.ID = R.ID_term2 
                    WHERE upper(T1.Term) REGEXP '[[:<:]]".$search_term."[[:>:]]' AND T1.Is_deleted=0 AND T2.Is_deleted=0 AND R.Is_deleted=0 
                        AND (R.Relationship='Use For')";
                    $result = db_query($db, $sql) ;
                    $data=db_fetch_assoc($result);
                    $preferred_term[$search_term]=strtoupper($data['Term']);
                }
                if($preferred_term[$search_term]!="") $related_terms[$search_term][]=$preferred_term[$search_term];

                //Find the narrower terms for the search term and the preferred term and the narrower of these until ther aren't any left.
                $terms[$search_term]=$related_terms[$search_term];
                while(!empty($terms[$search_term]))
                {
                    foreach($terms[$search_term] as $key=>$word)
                    {
                        $terms[$search_term][$key]="upper(T1.Term) REGEXP '[[:<:]]".$word."[[:>:]]'";
                    }
                    $condition=implode(" OR ", $terms[$search_term]);
                    $terms[$search_term] = array();

                    $sql = "SELECT T2.Term 
                    FROM thesaurus_term AS T2 
                    INNER JOIN thesaurus_relationship AS R ON T2.ID = R.ID_term2 
                    INNER JOIN thesaurus_term AS T1 ON T1.ID = R.ID_term1 
                    WHERE (".$condition.") AND T1.Is_deleted=0 AND T2.Is_deleted=0 AND R.Is_deleted=0 
                        AND (R.Relationship='NT')";

                    $result = db_query($db, $sql) ;
                    while($data=db_fetch_assoc($result))
                    {
                        if(!in_array(strtoupper($data['Term']), $related_terms[$search_term]))    
                        {
                            $terms[$search_term][]=strtoupper($data['Term']);
                            $related_terms[$search_term][]=strtoupper($data['Term']);
                        }
                    }

                    $sql = "SELECT T2.Term
                        FROM thesaurus_term AS T2 
                        INNER JOIN thesaurus_relationship AS R ON T2.ID = R.ID_term1 
                        INNER JOIN thesaurus_term AS T1 ON T1.ID = R.ID_term2 
                        WHERE (".$condition.") AND T1.Is_deleted=0 AND T2.Is_deleted=0 AND R.Is_deleted=0 
                            AND (R.Relationship='BT')";

                    $result = db_query($db, $sql) ;
                    while($data=db_fetch_assoc($result))
                    {
                        if(!in_array(strtoupper($data['Term']), $related_terms[$search_term]))    
                        {
                            $terms[$search_term][]=strtoupper($data['Term']);
                            $related_terms[$search_term][]=strtoupper($data['Term']);
                        }
                    }
                }

                //Find the related terms for the search term and the preferred term.
                $sql = "SELECT T2.Term 
                    FROM thesaurus_term AS T2 
                    INNER JOIN thesaurus_relationship AS R ON T2.ID = R.ID_term2 
                    INNER JOIN thesaurus_term AS T1 ON T1.ID = R.ID_term1 
                    WHERE (upper(T1.Term) REGEXP '[[:<:]]".$search_term."[[:>:]]' OR upper(T1.Term) = '".$preferred_term[$search_term]."') AND T1.Is_deleted=0 AND T2.Is_deleted=0 AND R.Is_deleted=0 
                        AND (R.Relationship='RT')";

                $result = db_query($db, $sql) ;
                while($data=db_fetch_assoc($result))
                {
                    if(!in_array(strtoupper($data['Term']), $related_terms[$search_term]))    
                    {
                        $related_terms[$search_term][]=strtoupper($data['Term']);
                    }
                }

                $sql = "SELECT T2.Term
                    FROM thesaurus_term AS T2 
                    INNER JOIN thesaurus_relationship AS R ON T2.ID = R.ID_term1 
                    INNER JOIN thesaurus_term AS T1 ON T1.ID = R.ID_term2 
                    WHERE (upper(T1.Term) REGEXP '[[:<:]]".$search_term."[[:>:]]' OR upper(T1.Term) = '".$preferred_term[$search_term]."') AND T1.Is_deleted=0 AND T2.Is_deleted=0 AND R.Is_deleted=0 
                        AND (R.Relationship='RT')";

                $result = db_query($db, $sql) ;
                while($data=db_fetch_assoc($result))
                {
                    if(!in_array(strtoupper($data['Term']), $related_terms[$search_term]))    
                    {
                        $related_terms[$search_term][]=strtoupper($data['Term']);
                    }
                }
            }

            //The search is performed within objects, samples and publications
            $array_classes=array('object', 'sample', 'publication', 'micrograph');
            
            //Definition of the info to be displayed (= the fields that are searched) for each of these 3 classes of items
            foreach($array_classes as $class)
            {
                echo"<br><br><h3>".$class."s</h3><br>";
                if ($class=="object")
                {
                    $fields_list="Type, Material, Site, Date_strati, Date_typo, Museum_nb, Field_nb, Catalogue_nb, Photo, Drawing";
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
                $i=0;
                foreach($related_terms as $search_term=>$array)
                {
                   $conditions=array();
                   foreach($detailed_fields_array as $field)
                   {
                        foreach($array as $term)
                        {
                            $conditions[$search_term][]="upper(".$field.") REGEXP '".$term."'";
                        }
                    }
                    $clause[$i]=implode(" OR ", $conditions[$search_term]);
                    $clause[$i]="(".$clause[$i].")";
                    $i=$i+1;
                }
                $clause_final=$clause[0];
                unset($clause[0]);
                if(!empty($clause))
                {
                    $clause_final=$clause_final." OR ".implode(" AND ", $clause);
                }

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
                display_table($db, $sql, $fields_array, $class, false, "search", 0, $search_text);
            }
            
            db_close($db);
            ?>
            <br><br>
        </div>
    </div>
<?php include 'footer.php'; ?>
</body>
</html> 
