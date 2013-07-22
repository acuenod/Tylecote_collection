<?php
//include 'db_connect.php';
include 'display_table.php';
function display_linked($id, $class, $form)
{
	$classes=array("object", "sample", "publication");
	$fields_list=array();
	$fileds_array=array();
	$fields_list['object']="Type, Site, Date_strati, Museum_nb, Field_nb, Catalogue_nb, Photo, Drawing";
	$fields_list['sample']="Sample_type, Sample_nb, Sample_material, Object_part, Photo";
	$fields_list['publication']="Author, Date, Title, Journal, Book_title";

	foreach ($fields_list as $key=>$list)
	{
            $fields_array[$key]=explode(", ", $fields_list[$key]);
	}


	$db=db_connect();
	
	if($class=="object")
	{
            echo"<h3>Related publications</h3>";
            $sql="SELECT ID, ".$fields_list['publication']." FROM publication INNER JOIN object_publication ON publication.ID=object_publication.ID_publication WHERE ID_object=".$id." AND Is_deleted=0";
            display_table($db, $sql, $fields_array['publication'], "publication", $form, "link", 0);
            echo"<br>";

            echo"<h3>Related samples</h3>";
            $sql="SELECT ID, ".$fields_list['sample']." FROM sample INNER JOIN sample_object ON sample.ID=sample_object.ID_sample WHERE ID_object=".$id." AND Is_deleted=0";
            display_table($db, $sql, $fields_array['sample'], "sample", $form, "link", 0);
	}
	
	if($class=="publication")
	{
            echo"<h3>Related objects</h3>";
            $sql="SELECT ID, ".$fields_list['object']." FROM object INNER JOIN object_publication ON object.ID=object_publication.ID_object WHERE ID_publication=".$id." AND Is_deleted=0";
            display_table($db, $sql, $fields_array['object'], "object", "false", "link", 0);
        }
	
	if($class=="sample")
	{
            echo"<h3>Related objects</h3>";
            $sql="SELECT ID, ".$fields_list['object']." FROM object INNER JOIN sample_object ON object.ID=sample_object.ID_object WHERE ID_sample=".$id." AND Is_deleted=0";
            display_table($db, $sql, $fields_array['object'], "object", "false", "link", 0);
	}
	
        db_close($db);
}

?>