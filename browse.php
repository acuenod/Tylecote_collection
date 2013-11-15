<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Browse database</title>
<link rel="stylesheet" href="mystyle.css">
</head>


<body>
    <div id="content">
        <?php include 'header.php'; ?>
        <div id="wrapper">

        <?php 
        include 'functions/db_connect.php';
        include 'functions/display_table.php';
       
        //Display title
        $class=$_GET["class"];
        echo"<h1>Browse ".$class."s</h1>";
        
        //Definition of how to order the search results depending on the class of item and whether a column has been clicked
        if (isset($_GET["sort_column"]))
        {
            $sort=$_GET["sort_column"];
        }
        elseif($class=="object")
        {
            $sort="Type";
        }
        elseif($class=="sample")
        {
            $sort="Sample_nb";
        }
        elseif($class=="publication")
        {
            $sort="Author";
        }
        
        if(!isset($_GET["order"]))
        {
            $order="ASC";
        }
        else
        {
            $order=$_GET["order"];
        }
        
        //Definition of the number of results per page and the page we are currently on
        $rpp=10;
        if(isset($_GET['page']))
        {
            $page=$_GET['page'];
        }
        else
        {
            $page=1;
        }
        
        //Definition of the fields to be displayed for each class of items
        $fields_array=array();
        if ($class=="object")
        {
                $fields_list="Type, Material, Site, Date_strati, Date_typo, Museum_nb, Field_nb, Photo, Drawing";
        }
        elseif ($class=="sample")
        {
                $fields_list="Sample_type, Sample_nb, Sample_material, Object_part, Photo";
        }
        elseif ($class=="publication")
        {
                $fields_list="Author, Date, Title, Journal";
        }
        $fields_array=explode(", ", $fields_list);
        
        //Displays the collection and drawer info and navigation buttons for samples browsing 
        if (isset($_GET["collection"]) && isset($_GET["drawer"]))
        {
            echo"<div id='go_back'><a href=\"browse_choice.php?class=sample&collection=".$_GET['collection']."\"'>< Back to drawers</a></div>";
            echo"<h2>".$_GET["collection"]." collection, drawer ".$_GET["drawer"].".</h2>";
        }
        
        echo"Click on a line to see more detail <br><br>";
        
        $db=db_connect();
        
        //Definition of the clause for the SQL request that fetches the items to be displayed: only "not deleted" for objects and publication. Collection and drawer info for samples.
        $clause="Is_deleted=0";
        if (isset($_GET["collection"])) $clause=$clause." AND Collection='".$_GET["collection"]."'";
        if (isset($_GET["drawer"])) $clause=$clause." AND Drawer='".$_GET["drawer"]."'";

        //Counts the number of items to be displayed in order to calculate the number of pages of results
        $sql="SELECT count(*) FROM ".$class." WHERE ".$clause;
        $result = db_query($db, $sql);
        $numrows = db_fetch_row($result);
        $numpages = ceil($numrows[0] / $rpp); 

        //Definition of all the info to pass with $_GET
        $address="";
        if (isset($_GET["order"])) $address=$address."&order=".$_GET["order"];
        if (isset($_GET["collection"])) $address=$address."&collection=".$_GET["collection"];
        if (isset($_GET["drawer"])) $address=$address."&drawer=".$_GET["drawer"];

        //Displays navigation buttons between pages above the table
        if($page > 1)
        {
            echo"<input type='button' name='goto_first' value='<<  First' onclick='self.location.href=\"?sort_column=".$sort."&page=1&class=".$class.$address."\"'>   ";
            echo"<input type='button' name='goto_previous' value='< Previous' onclick='self.location.href=\"?sort_column=".$sort."&page=".($page - 1)."&class=".$class.$address."\"'>";
        }
        if($page < $numpages)
        {
           echo"<input type='button' name='goto_next' value='Next >' onclick='self.location.href=\"?sort_column=".$sort."&page=".($page + 1)."&class=".$class.$address."\"'>";
           echo"<input type='button' name='goto_last' value='Last >>' onclick='self.location.href=\"?sort_column=".$sort."&page=".($numpages)."&class=".$class.$address."\"'>";
        }
        
        //Diplays the number of the page we are on
        echo"&nbsp &nbsp &nbsp Page <b>".$page."</b> of ".$numpages."<br>";
       
        //Fetches the items to be diplayed in the database and displays the table of results
        $sql = "SELECT ID, ".$fields_list." FROM ".$class." WHERE ".$clause." ORDER BY ".$sort." ".$order." LIMIT ".($rpp * ($page-1)).", ".($rpp);
        display_table($db, $sql, $fields_array, $class, false, 0, "browse", $page);
        
        //Displays navigation buttons between pages again under the table
        if($page > 1)
        {
            echo"<input type='button' name='goto_first' value='<<  First' onclick='self.location.href=\"?sort_column=".$sort."&page=0&class=".$class.$address."\"'>   ";
            echo"<input type='button' name='goto_previous' value='< Previous' onclick='self.location.href=\"?sort_column=".$sort."&page=".($page - 1)."&class=".$class.$address."\"'>";
        }
        if($page < $numpages)
        {
           echo"<input type='button' name='goto_previous' value='Next >' onclick='self.location.href=\"?sort_column=".$sort."&page=".($page + 1)."&class=".$class.$address."\"'>";
           echo"<input type='button' name='goto_last' value='Last >>' onclick='self.location.href=\"?sort_column=".$sort."&page=".($numpages)."&class=".$class.$address."\"'>";
        }

        db_close($db);
        ?>
        <br><br>
        </div>
    </div>
<?php include 'footer.php'; ?>
</body>
</html> 