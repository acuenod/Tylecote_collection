<?php 

 /*
  * This page searches the database for the data requested by the user and
  * created an Excel file containing the exported table, which is saved on the client's side.
  * It uses the PHPExcel library downloadable at http://www.phpexcel.net
  * It is very similar to the tables_results.php page, except it creates a PHPExcel object
  * rather than an html table.
 */

include 'functions/db_connect.php';
include 'functions/search_functions.php';
include 'functions/tables_functions.php';
include 'globals.php';
include 'classes/PHPExcel.php';
include 'classes/PHPExcel/Writer/Excel2007.php';

//Set memory limit as the creation of the PHPExcel object uses up a lot of memory
ini_set("memory_limit","500M");


$db=db_connect();
global $field_title;            

$post=array();
foreach($_POST as $key=>$string)
{
    $post[$key]=unserialize($string);
}

//Definition of the where clause for the search of the objects corresponding to the request
$clause= tables_where_clause($post['search_text'], $post['search_field'], $post['operator']);

//Definition of the table for the search of the objects corresponding to the request
$table="object JOIN sample_object ON object.ID = sample_object.ID_object JOIN sample ON ID_sample = sample.ID
                JOIN object_publication ON object.ID = object_publication.ID_object JOIN publication ON ID_publication = publication.ID ";

//Definition of the correspondance between the selected info to be displayed and the fields in the tables
$correspondance=define_fields($post);
$display_fields=$correspondance['simple_fields'];
$display_detailed_fields=$correspondance['detailed_fields'];

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties of PHPExcel object
$objPHPExcel->getProperties()->setTitle("Metallography Exported Table");

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
    //Writes the first line of the excel sheet
    $rowNumber=1; //Row counter for the excel export
    $col='A'; //Column counter for the excel export
    foreach($display_fields as $class=> $array)
    {
        foreach($array as $field)
        {
            $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber, strip_tags($field_title[$field]));
            //Gives the header line of the excel sheet a grey background
            $objPHPExcel->getActiveSheet()->getStyle($col.$rowNumber)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
            $objPHPExcel->getActiveSheet()->getStyle($col.$rowNumber)->getFill()->getStartColor()->setARGB('FFA9A9A9');
            $col++;
        }
    }
    $rowNumber++;

    //Finds all the results in the object table. For each found result finds the samples, publications, metallo and chemistry linked to this object
    $sql="SELECT DISTINCT ".$fields_list['object']." FROM ".$table." WHERE sample.Is_deleted=0 AND (".$clause.")";
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
            $data['Image']="Images not dispayed in Excel";
        }
        //Get the info related to this object in all of the other tables (sample, publication, metallography and chemistry) 
        $linked_data=get_linked_data($data['ID'], $display_fields, $fields_list);
        $rows=$linked_data['rows'];
        $numrows=$linked_data['numrows'];
        
        //Writes the rows into the excel spreadsheet
        if(isset($rows)) //If the user is asking for more than just information on the object
        {
            //Defines the number of rows to be merged
            if(max($numrows)>0)
            {
                $max_rows=max($numrows);
            }
            else    $max_rows=1;
            $col='A'; //Column counter for the excel export
            foreach($display_fields['object'] as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber, strip_tags($data[$field]));
                $objPHPExcel->getActiveSheet()->mergeCells($col.$rowNumber.":".$col.($rowNumber+$max_rows-1));
                $col++;
            }
            $first_unmerged_column=$col;
            $i=0;
            while($i<$max_rows)
            {
                $col=$first_unmerged_column;
                foreach($display_fields as $class=>$array)
                {
                    if($class!='object')
                    {
                        foreach($array as $field)
                        {
                            if(isset($rows[$class][$i]))
                            {
                                $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber, strip_tags($rows[$class][$i][$field]));
                            }
                            $col++;
                        }   
                    }
                }
                $i++;
                $rowNumber++;
            }
        }
        else //If there is only information on the object (no need to merge the cells for the display of the object infos)
        {
            $col="A";
            foreach($display_fields['object'] as $field)
            {
                $objPHPExcel->getActiveSheet()->setCellValue($col.$rowNumber, strip_tags($data[$field]));
            }
            $rowNumber++;
        }
    }
}

// redirect output to client browser
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="exported_table.xlsx"');
header('Cache-Control: max-age=0');

//Create excel file
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

$objWriter->save('php://output');

db_close($db);
?>