<?php
/*
 * These functions are used in both tables_result and table_export
 */

/*
 * The function tables_where_clause defines the where clause for the search of the objects corresponding to the request.
 * it loops through the (up to) three search terms and fields entered, finds the related, preferred, narrower terms etc.
 * converts the search fields from the drop-down menu into actual filed from the database
 * and writes the full where clause for the sql search.
 */

function tables_where_clause($search_terms, $search_fields, $search_operators)
{
    global $fields_correspondance;
    $clause="";
    foreach($search_terms as $key=>$text)
    {
        if($text!="")
        {
            //Definition of the related terms from the thesaurus (preferred, narrower and related terms) for each search terms entered in the form
            $related_terms[$key]=search_related_terms($text);
            //Definition of the fields in which to search for each of the search terms entered in the form
            $detailed_fields_array[$key]=$fields_correspondance[$search_fields[$key]];
            //Definition of the where clause for the SQL request
            if($clause=='')
            {
                $clause="(".write_where_clause($related_terms[$key], $detailed_fields_array[$key]).")";
            }
            else
            {
                $clause=$clause." ".$search_operators[$key-1]." (".write_where_clause($related_terms[$key], $detailed_fields_array[$key]).")";
            }
        }
    }
    return $clause;
}

/*
 * The function define_fields simply established the correspondance between the name of the tickboxes selected
 * by the user in part 2 of tables_choices.php and the names of the fields in the SQL tables.
 * It returns two arrays, $display_fields will be used to display the column headers
 * $display_detailed_fields contains the detailed SQL tables fields names in the format table.Field for use
 * in the SQL search. 
 */
function define_fields($post)
{
    if(isset($post['object']))
    {
        foreach($post['object'] as $field)
        {
            if($field!="Identification" && $field!="Publication" && $field!="Image")
            {
                $display_fields['object'][]=$field;
                $display_detailed_fields['object'][]="object.".$field;
            }
            elseif($field=="Identification")
            {
                $display_fields['object'][]="Identification";
                $display_detailed_fields['object'][]="object.Museum_nb";
                $display_detailed_fields['object'][]="object.Field_nb";
                $display_detailed_fields['object'][]="object.Catalogue_nb";
            }
            elseif($field=="Image")
            {
                $display_fields['object'][]="Image";
                $display_detailed_fields['object'][]="object.Photo";
                $display_detailed_fields['object'][]="object.Drawing";
            }
        }
    }
    if(isset($post['sample']))
    {
        foreach($post['sample'] as $field)
        {
            if($field!="Location")
            {
                $display_fields['sample'][]=$field;
                $display_detailed_fields['sample'][]="sample.".$field;
            }
            elseif($field=="Location")
            {
                $display_fields['sample'][]="Location";
                $display_detailed_fields['sample'][]="sample.Drawer";
                $display_detailed_fields['sample'][]="sample.Location_new_code";
            }
        }
    }
    if(isset($post['publication']))
    {
        foreach($post['publication'] as $field)
        {
           $display_fields['publication'][]=$field;
           $display_detailed_fields['publication'][]="publication.".$field;
        }
    }
    if(isset($post['metallography']))
    {
        foreach($post['metallography'] as $field)
        {
            if($field!="Micrograph" && $field!="Micrograph_features")
            {
                $display_fields['metallography'][]=$field;
                $display_detailed_fields['metallography'][]="metallography.".$field;
            }
            elseif($field=="Micrograph")
            {
                $display_fields ['micrograph'][]="Micrograph";
                $display_detailed_fields['micrograph'][]="micrograph.File";
            }
            elseif($field=="Micrograph_features")
            {
                $display_fields ['micrograph'][]="Micrograph_features";
                $display_detailed_fields['micrograph'][]="micrograph.Cu_structure";
                $display_detailed_fields['micrograph'][]="micrograph.Fe_structure";
                $display_detailed_fields['micrograph'][]="micrograph.Porosity";
                $display_detailed_fields['micrograph'][]="micrograph.Corrosion";
                $display_detailed_fields['micrograph'][]="micrograph.Inclusions";
                $display_detailed_fields['micrograph'][]="micrograph.C_content";
            }
        }
        if(isset($display_fields['micrograph']) && !isset($display_fields['metallography']))
        {
            $display_fields['metallography']=array();
        }
        if(isset($display_detailed_fields['micrograph']) && !isset($display_detailed_fields['metallography']))
        {
            $display_detailed_fields['metallography']=array();
        }
    }
    if(isset($post['chemistry']))
    {
        foreach($post['chemistry'] as $field)
        {
            if($field!="Elements_Cu" && $field!="Elements_Fe" && $field!="Oxides")
            {
                $display_fields['chemistry'][]=$field;
                $display_detailed_fields['chemistry'][]="chemistry.".$field;
            }
            elseif($field=="Elements_Cu")
            {
                $display_fields ['chemistry'][]="Cu";
                $display_fields ['chemistry'][]="Sn";
                $display_fields ['chemistry'][]="Pb";
                $display_fields ['chemistry'][]="Zn";
                $display_fields ['chemistry'][]="Arsenic";
                $display_fields ['chemistry'][]="Sb";
                $display_fields ['chemistry'][]="Ag";
                $display_fields ['chemistry'][]="Ni";
                $display_fields ['chemistry'][]="Co";
                $display_fields ['chemistry'][]="Bi";
                $display_fields ['chemistry'][]="Fe";
                $display_fields ['chemistry'][]="Au";
                $display_detailed_fields ['chemistry'][]="chemistry.Cu";
                $display_detailed_fields ['chemistry'][]="chemistry.Sn";
                $display_detailed_fields ['chemistry'][]="chemistry.Pb";
                $display_detailed_fields ['chemistry'][]="chemistry.Zn";
                $display_detailed_fields ['chemistry'][]="chemistry.Arsenic";
                $display_detailed_fields ['chemistry'][]="chemistry.Sb";
                $display_detailed_fields ['chemistry'][]="chemistry.Ag";
                $display_detailed_fields ['chemistry'][]="chemistry.Ni";
                $display_detailed_fields ['chemistry'][]="chemistry.Co";
                $display_detailed_fields ['chemistry'][]="chemistry.Bi";
                $display_detailed_fields ['chemistry'][]="chemistry.Fe";
                $display_detailed_fields ['chemistry'][]="chemistry.Au";
            }
            elseif($field=="Elements_Fe")
            {
                $display_fields ['chemistry'][]="Fe";
                $display_fields ['chemistry'][]="Si";
                $display_fields ['chemistry'][]="Mn";
                $display_fields ['chemistry'][]="P";
                $display_detailed_fields ['chemistry'][]="chemistry.Fe";
                $display_detailed_fields ['chemistry'][]="chemistry.Si";
                $display_detailed_fields ['chemistry'][]="chemistry.Mn";
                $display_detailed_fields ['chemistry'][]="chemistry.P";
            }
            elseif($field=="Oxides")
            {
                $display_fields ['chemistry'][]="SiO2";
                $display_fields ['chemistry'][]="FeO";
                $display_fields ['chemistry'][]="MnO";
                $display_fields ['chemistry'][]="BaO";
                $display_fields ['chemistry'][]="P2O5";
                $display_fields ['chemistry'][]="CaO";
                $display_fields ['chemistry'][]="Al2O3";
                $display_fields ['chemistry'][]="K2O";
                $display_fields ['chemistry'][]="MgO";
                $display_fields ['chemistry'][]="TiO2";
                $display_fields ['chemistry'][]="SO3";
                $display_fields ['chemistry'][]="Na2O";
                $display_fields ['chemistry'][]="V2O5";
                $display_detailed_fields ['chemistry'][]="chemistry.SiO2";
                $display_detailed_fields ['chemistry'][]="chemistry.FeO";
                $display_detailed_fields ['chemistry'][]="chemistry.MnO";
                $display_detailed_fields ['chemistry'][]="chemistry.BaO";
                $display_detailed_fields ['chemistry'][]="chemistry.P2O5";
                $display_detailed_fields ['chemistry'][]="chemistry.CaO";
                $display_detailed_fields ['chemistry'][]="chemistry.Al2O3";
                $display_detailed_fields ['chemistry'][]="chemistry.K2O";
                $display_detailed_fields ['chemistry'][]="chemistry.MgO";
                $display_detailed_fields ['chemistry'][]="chemistry.TiO2";
                $display_detailed_fields ['chemistry'][]="chemistry.SO3";
                $display_detailed_fields ['chemistry'][]="chemistry.Na2O";
                $display_detailed_fields ['chemistry'][]="chemistry.V2O5";
            }
        }
    }
    $correspondance=array();
    $correspondance['simple_fields']=$display_fields;
    $correspondance['detailed_fields']=$display_detailed_fields;
    return $correspondance;
}

/*
 * The function define_image_html looks through the Photo and Drawing fields of the object table
 * and selects the one that isn't empty. If they are both not empty, the Photo is selected.
 * It then gets the size of the image
 * It returns the html IMG tag that will display the image in the correct size.
 * If the user hasn't logged on, the image in not displayed (for copyright reasons)
 */
function define_image_html($data)
{
    if(isset($_SESSION["access"]))
    {
        if(isset($data["Photo"]) && $data["Photo"]!='')
        {
            $img=$data["Photo"];
            $img_folder="Photo";
            $img_size=getimagesize("upload/object/Photo/".$data["Photo"]);
        }
        elseif(isset($data["Drawing"]) && $data["Drawing"]!='')
        {
            $img=$data["Drawing"];
            $img_folder="Drawing";
            $img_size=getimagesize("upload/object/Drawing/".$data["Drawing"]);
        }
        else
        {
            $img="";
            $img_size=array(0,0);
        }
        if(isset($img) && $img!="")
        {
            $img_html="<IMG SRC='upload/object/".$img_folder."/".$img."' ALT='No image' TITLE='Image'".($img_size[0]>$img_size[1]?"width='60'":"height='60'").">";
        }
        else $img_html="No image";
    }
    else $img_html="Image not displayed for copyright reasons.";
    return $img_html;
}


/*
 * The get_linked_data function is given the id of an object and searches the database for all
 * the related information (as chosen by the user in the tickboxes of the tables_choice.php form)
 * in all classes (samples, publications, metallography and chemistry).
 * For each metallography found it also finds all the micrographs linked to this metallography.
 * There is a counter to determine the number of results in each class for a given object.
 * The maximum of this counter is then used in the display of the table to determine how many cells need
 * to be merged when displaying the object related information. 
 */

function get_linked_data($ID_object, $display_fields, $fields_list)
{
    $db=db_connect();
    foreach($display_fields as $class=>$array)
    {
        if($class!="object" && $class!="micrograph")
        {   
            if($class=="sample")
            {
                $table="sample JOIN sample_object ON sample.ID=sample_object.ID_sample";
            }
            elseif($class=="publication")
            {
                $table="publication JOIN object_publication ON publication.ID=object_publication.ID_publication";
            }
            else
            {
                $table=$class;
            }
            $sql2[$class]="SELECT DISTINCT ".$fields_list[$class]." FROM ".$table." WHERE ID_object=".$ID_object." AND Is_Deleted=0";
            $result2[$class] = db_query($db, $sql2[$class]);
            //Counts the number of rows found in each class to know how many cells need to be merged (vertically when displaying hte information on the object
            $rows[$class]=array();
            $i=0;   //counter for sample, publications, metallography and chemistry
            $j=0;   //counter for micrographs
            while($data2[$class]= db_fetch_assoc($result2[$class]))
            {
                $rows[$class][$i]=$data2[$class];
                //Concatenation of the Location fields (Drawer, Location_new_code) into a single field separated with "/"
                if($class=='sample' && in_array("Location", $display_fields['sample']))
                {
                    $rows[$class][$i]['Location']=implode(" /<br>", array_filter(array("Drawer: ".$data2['sample']['Drawer'], $data2['sample']['Location_new_code'])));
                }
                //Finds all the micrograph and their information for each metallography
                if($class=="metallography" && isset($fields_list['micrograph']))
                {
                    $rows['micrograph']=array();
                    $sql2['micrograph']="SELECT DISTINCT Is_public, ".$fields_list['micrograph']." FROM micrograph WHERE ID_metallography=".$data2['metallography']['ID']." AND Is_Deleted=0";
                    $result2['micrograph'] = db_query($db, $sql2['micrograph']);
                    while($data2['micrograph']= db_fetch_assoc($result2['micrograph']))
                    {
                        //Concatenation of the Micrograph_features fields (Cu_structure, Fe_structure, Porosity, Corrosion, Inclusions, C_content) into a single field separated with "/"
                        if (in_array('Micrograph_features', $display_fields['micrograph']))
                        {
                            $rows['micrograph'][$j]['Micrograph_features']=implode(" / ", array_filter(array($data2['micrograph']['Cu_structure'], $data2['micrograph']['Fe_structure'], $data2['micrograph']['Porosity'], $data2['micrograph']['Corrosion'], $data2['micrograph']['Inclusions'], $data2['micrograph']['C_content'])));
                        }
                        //Deals with the micrograph images
                        if(in_array("Micrograph", $display_fields['micrograph']))
                        {
                            if(isset($data2['micrograph']['File']) && $data2['micrograph']['File']!='')
                            {
                                if($data2['micrograph']['Is_public']=="Y" || isset($_SESSION['access']))
                                {
                                    $micro=$data2['micrograph']['File'];
                                    $micro_size=getimagesize("upload/micrograph/File/".$data2['micrograph']['File']);
                                    $rows['micrograph'][$j]['Micrograph']="<IMG SRC='upload/micrograph/File/".$micro."' ALT='No image' TITLE='Image'".($micro_size[0]>$micro_size[1]?"width='60'":"height='60'").">";
                                }
                                else
                                {
                                    $rows['micrograph'][$j]['Micrograph']="Micrograph not displayed for copyright reasons";
                                }
                            }
                        }
                        $j++;
                    }
                }
                $i++;
            }
        }
    }
    foreach($display_fields as $class=>$array)
    {
        if($class!="object")
        {   
            if(isset($rows[$class]))
            {   
                $numrows[$class]=count($rows[$class]);
            }
        }
    }
    
    db_close($db);
    $result=array();
    $result['rows']=$rows;
    $result['numrows']=$numrows;
    return $result;
}
?>