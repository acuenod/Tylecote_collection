<?php

/*function designed to display a clickable table of results from an sql request
arguments:
 * $sql: the SQL query
 * $fields_array: array of the fields that we want to display in the table
 * $class: string, the table in which the request is taking place (object, sample, publication, thesaurus_term)
 * $form: string, "check" if the table checkboxes of an html form: it will display a clikable box in the first colum of the table; "radio" if the first column is a radio button (used in display linked)
 * $checked: int, id of an element that should be preselected if the table is a form. 0 otherwise.
 * $action: string, "browse" "search" "link" or "thesaurus". "Browse" displays the results over several pages. Otherwise the table uses the sortable class to order the table by clicking on the column headers
 * $page: int. Indicates the number of the age of results that is displayed. Set to 0 if not on browse result
 * $search_text: string, optional. Passes the text of the search to the function
 * 
 * In link_items.php, search_results.php and display_linked in detailed_view.php, the table class is 'tablesorter'.
 * This enable to alphabetically sort the table by clicking on one of the headers without reloading the page.
 * It uses a jQuery plugin: jquery.tablesorter.
 * 
 * In browse_results.php the table class is "normal", but the headers are clickable to sort the table,
 * this reloads the page and reruns the sql query using ORDER BY Field ASC or DSC in the SQL.
 * This is so that the results can be sorted AND displayed over several pages
 * 
 */
include $_SERVER['DOCUMENT_ROOT']."/Tylecote_collection/globals.php";

function display_table($db, $sql, $fields_array, $class, $form, $checked, $action, $page, $search_text=null)
{
        global $field_title;
        echo"<script src='/Tylecote_collection/functions/navigation.js'></script>";
        
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
                if($class!='micrograph')
                {
                    $_SESSION['search_results'][$class][]=$data['ID'];
                }
                else
                {
                    $_SESSION['search_results'][$class][]=$data['ID_object'];
                }
            }
        }
        if(isset($_GET['order']))
        {
            if($_GET['order']=="ASC")   $order="DESC";
            elseif($_GET['order']=="DESC")   $order="ASC";
        }
        else    $order="ASC";
        
        //Displays the headers of the table differently depending on the action we come from
        if($action=="browse")
        {
            echo"<table class='normal'>";
        }
        elseif($action=="search" || $action=="link")
        {
            echo"<table id='".$class."' class='tablesorter'>";
        }
        else
        {
            echo"<table id='".$class."' class='tablesorter' width=60%>";
        }
	echo "<thead><tr>";
	if($form=="check" || $form=="radio")
	{
            echo"<th></th>";
	}
	foreach ($fields_array as $key=>$field)
	{
            if($field!="Photo" && $field!="Drawing" && $field!="File" && $field!="ID_metallography" && $field!="ID_object" && $field!="Description")
            {
                if($action=="browse")
                {
                    if($class=="sample")
                        echo "<th onmouseover='ChangeColorHeader(this, true)' onmouseout='ChangeColorHeader(this, false)' onclick=DoNav('".$filename."?sort_column=".$field."&order=".$order."&class=".$class."&collection=".$_GET['collection']."&drawer=".$_GET['drawer']."');>".$field_title[$field]."</th>";
                    else
                        echo "<th onmouseover='ChangeColorHeader(this, true)' onmouseout='ChangeColorHeader(this, false)' onclick=DoNav('".$filename."?sort_column=".$field."&order=".$order."&class=".$class."');>".$field_title[$field]."</th>";
                }
                else
                {   
                    echo "<th>".$field_title[$field]."</th>";
                }
            }
	}
	if($class!="publication" && $class!="thesaurus_term" && $class!="object" || ($class=="object" && isset($_SESSION['access'])))
	{
            echo"<th>Photo</th>";
	}
        if($action=="link" && $filename=="detailed_view.php" && isset($_SESSION["access"]) && $_SESSION["access"]>1)
        {
            echo"<th>Unlink</th>";
        }
        echo"<tr></thead>";
        echo"<tbody>";
        
        
        //Displays the rows of the table
        $result = db_query($db, $sql);
	while($data= db_fetch_assoc($result))
	{
            //Deals with the image files
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
            elseif(isset($data["File"]) && $data["File"]!='')
            {
                $img=$data["File"];
                $img_folder="File";
                $img_size=getimagesize($path."upload/".$class."/File/".$data["File"]);
            }
            else
            {
                $img="";
                $img_size=array(0,0);
            }
            
            //Sets the variable $is_Checked to "" if this line isn't selected, "checked" if it is.
            if($data['ID']==$checked)
            {
                $is_Checked="checked";
            }
            else $is_Checked="";
            
                        
            echo "<tr onmouseover='ChangeColor(this, true)' onmouseout='ChangeColor(this, false)' class='normal' >";

            if($form=="check")
            {
                echo"<th><input type='checkbox' name='ID_".$class."[]' value=".$data['ID']." ".$is_Checked."></th>";
            }
            elseif($form=="radio")
            {
                echo"<th><input type='radio' name='ID_".$class."' value=".$data['ID']." ".$is_Checked."></th>";
            }

            //Definition of the URL to go to when a cell is clicked, with all of the information on where we come from in GET
            if($class == 'micrograph')
            {
                $address="/Tylecote_collection/detailed_view.php?id=".$data['ID_object']."&class=object&action=".$action."&interest=micrograph";
            }
            else
            {
                $address="/Tylecote_collection/detailed_view.php?id=".$data['ID']."&class=".$class."&action=".$action;
            }
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
                    if($field!="Photo" && $field!="Drawing" && $field!="File" && $field!="ID_metallography" && $field!="ID_object" && $field!="Description")
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
                echo"<td onclick=DoNav('".$address."')><IMG SRC='".$path."upload/".$class."/".$img_folder."/".$img."' ALT='No image' TITLE='Image'".($img_size[0]>$img_size[1]?"width='60'":"height='60'")."></td>";
            }
            elseif($class!="publication" && $class!="thesaurus_term" && $class!="object" || ($class=="object" && isset($_SESSION['access'])))
            {
                echo"<td onclick=DoNav('/Tylecote_collection/detailed_view.php?id=".$data['ID']."&class=".$class."');></td>";
            }
            
            //If we are displaying linked items in a Writer or Admin mode, give the option to unlink the items
            if($action=="link" && $filename=="detailed_view.php" && isset($_SESSION["access"]) && $_SESSION["access"]>1)
            {
                echo"<td>
                    <form action='writer/unlink_results.php' method='post'>
                    <input type=hidden name='ID_element' value=".$_GET['id'].">
                    <input type=hidden name='class_element' value=".$_GET['class'].">
                    <input type=hidden name='ID_linked' value=".$data['ID'].">
                    <input type=hidden name='class_linked' value=".$class.">
                    <input type='submit' value='Unlink' onClick='return  confirm_unlink()'>
                    </form>
                    </td>";
            }
            echo"</tr>";
	}
        //Adds the option of no known publications or samples related to a micrograph in case a radio button has been selected by mistake
        if($form=="radio")
        {
            echo"<tr><th><input type='radio' name='ID_".$class."' value='0'></th>
                <td colspan=5>No known ".$class." relating to this micrograph</td></tr>";
        }
        echo"</tbody>";
	echo"</table>";
}

?>