<?php

/*function designed to display a clickable table of results from an sql request
arguments:
 * $sql: the SQL query
 * $fields_array: array of the fields that we want to display in the table
 * $class: string, the table in which the request is taking place (object, sample, publication, thesaurus_term)
 * $form: string, "check" if the table checkboxes of an html form: it will display a clikable box in the first colum of the table; "radio" if the first column is a radio button
 * $action: string, "browse" "search" "link" or "thesaurus". "Browse" displays the results over several pages. Otherwise the table uses the sortable class to order the table by clicking on the column headers
 * $page: int. Indicates the number of the age of results that is displayed. Set to 0 if not on browse result
 * $search_text: string, optional. Passes the text of the search to the function
 */

function display_table($db, $sql, $fields_array, $class, $form, $action, $page, $search_text=null)
{
        
        echo"<script src='/Tylecote_collection/functions/navigation.js'></script>";
        if($action=="search" || $action=="thesaurus")
        {
            echo"<script src='/Tylecote_collection/functions/sorttable.js'></script>";
            /* Not sure why, if I call this script, the navigation one doesn't work.
             * This is why I don't call it for link
             */
        }
       
        
	$currentFile = $_SERVER["PHP_SELF"];
	$parts = Explode('/', $currentFile);
	$filename=$parts[count($parts) - 1];
	$parent_file=$parts[count($parts) - 2];
        if($parent_file!="Tylecote_collection")
        {
            $path="../";
        }
        else $path="";
        
        //Allows to find all the browse results, not only the one which page we are on
        if($action=="browse")
        {
            $exploded_sql=explode("LIMIT", $sql);
            $sql2=$exploded_sql[0];
        }
        else $sql2=$sql;
        
        //Puts the search (or browse) results in an array that is put in a session variable
        //so that the next and previous buttons of display results stays within the search results
        if($action!="link")
        {
            $_SESSION['search_results'][$class]=array();
            $result = db_query($db, $sql2);
            while($data= db_fetch_assoc($result))
            {
                $_SESSION['search_results'][$class][]=$data['ID'];
            }
        }
        if(isset($_GET['order']))
        {
            if($_GET['order']=="ASC")   $order="DESC";
            elseif($_GET['order']=="DESC")   $order="ASC";
        }
        else    $order="ASC";
        
        //Displays the headers of the table differently depending on the class
        if($action=="browse")
        {
            echo"<table border=1 cellspacing=0 cellpadding=3 class='normal'>";
        }
        elseif($action=="search")
        {
            echo"<table border=1 cellspacing=0 cellpadding=3 class='sortable'>";
        }
        else
        {
            echo"<table border=1 cellspacing=0 cellpadding=3 class='sortable' width=60%>";
        }
	echo "<tr>";
	if($form=="check" || $form=="radio")
	{
		echo"<th></th>";
	}
	foreach ($fields_array as $key=>$field)
	{
		if($field!="Photo" && $field!="Drawing")
		{
                        if($action=="browse")
                        {
                            if($class=="sample")
                                echo "<th onmouseover='ChangeColorHeader(this, true)' onmouseout='ChangeColorHeader(this, false)' onclick=DoNav('".$filename."?sort_column=".$field."&order=".$order."&class=".$class."&collection=".$_GET['collection']."&drawer=".$_GET['drawer']."');>".$field."</th>";
                            else
                                echo "<th onmouseover='ChangeColorHeader(this, true)' onmouseout='ChangeColorHeader(this, false)' onclick=DoNav('".$filename."?sort_column=".$field."&order=".$order."&class=".$class."');>".$field."</th>";
                        }
                        else
                        {   
                            echo "<th onmouseover='ChangeColorHeader(this, true)' onmouseout='ChangeColorHeader(this, false)'>".$field."</th>";
                        }
		}
	}
	if($class!="publication" && $class!="thesaurus_term")
	{
		echo"<th>Photo</th><tr>";
	}
        
        
        //Displays the rows of the table
        $result = db_query($db, $sql);
	while($data= db_fetch_assoc($result))
	{
                if(isset($data["Photo"]) && $data["Photo"]!='')
		{
                        $img=$data["Photo"];
                        $img_folder="Photo";
			$img_size=getimagesize($path."upload/".$class."/Photo/".$data["Photo"]);
		}
                elseif(isset($data["Drawing"]) && $data["Drawing"]!='')
		{
                        $img=$data["Drawing"];
                        $img_folder="Drawing";
			$img_size=getimagesize($path."upload/".$class."/Drawing/".$data["Drawing"]);
		}
		else
		{
                        $img="";
			$img_size=array(0,0);
		}
                
		echo "<tr onmouseover='ChangeColor(this, true)' onmouseout='ChangeColor(this, false)' class='normal' >";
		
		if($form=="check")
		{
                    echo"<th><input type='checkbox' name='ID_".$class."[]' value=".$data['ID']."></th>";
		}
                elseif($form=="radio")
		{
                    echo"<th><input type='radio' name='ID_".$class."' value=".$data['ID']."></th>";
		}
                
                //Definition of the URL to go to when a cell is clicked, with all of the information on where we come from in GET
                $address="/Tylecote_collection/detailed_view.php?id=".$data['ID']."&class=".$class."&action=".$action;
                if(isset($_GET['collection']) && isset($_GET['drawer']))
                {
                    $address=$address."&collection=".$_GET['collection']."&drawer=".$_GET['drawer'];
                }
                if(isset($_GET['sort_column']))
                {
                    $address=$address."&sort_column=".$_GET['sort_column'];
                }
                if(isset($_GET['order']))
                {
                    $address=$address."&order=".$_GET['order'];
                }
                if(isset($page))
                {
                    $address=$address."&page=".$page;
                }
                if(isset($search_text))
                {
                    $address=$address."&search_text=".str_replace(" ", "_", $search_text);
                }
                
                //Display each cell
		foreach ($fields_array as $key=>$field)
		{
			if($class!="thesaurus_term")
			{
                            if($field!="Photo" && $field!="Drawing")
                            {
                                echo"<td onclick=DoNav('".$address."')>".$data[$field]."</td>";
                            }
			}
                        elseif($class=="thesaurus_term")
                        {
                            	echo"<td onclick=DoNav('/Tylecote_collection/admin/edit_thesaurus.php?id=".$data['ID']."');>".$data["$field"]."</td>";
                        }
                        
		}
		if(isset($img) && $img!="")
		{
			echo"<td onclick=DoNav('".$address."')><IMG SRC='".$path."upload/".$class."/".$img_folder."/".$img."' ALT='No image' TITLE='Image'".($img_size[0]>$img_size[1]?"width='60'":"height='60'")."></td></tr>";
		}
                elseif($class!="publication" && $class!="thesaurus_term") {
                    	echo"<td onclick=DoNav('/Tylecote_collection/detailed_view.php?id=".$data['ID']."&class=".$class."');></td></tr>";
                }
                else echo"</tr>";
                
	}
	echo"</table>";
}

?>