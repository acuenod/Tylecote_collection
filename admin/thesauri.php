<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Thesauri</title>
<link rel="stylesheet" href="../mystyle.css">
</head>


<body>
    <div id="content">
	<?php include '../header.php'; ?>
	<div id="wrapper">
            
            <h1>Thesauri management</h1>
            <?php
            include '../functions/db_connect.php';
            include '../functions/display_table.php';
            
            $db=db_connect();
            
            //Deals with the forms coming from thesaurus_edit.php
            
            //Defines a table of what the invert of each relationship is
            $invert_relationship=array();
            $invert_relationship['Use For']="Use";
            $invert_relationship['Use']="Use For";
            $invert_relationship['NT']="BT";
            $invert_relationship['BT']="NT";
            $invert_relationship['RT']="RT";
            
            if(isset($_POST) && !empty($_POST)) //If we come from thesaurus_edit.php
            {
                if(isset($_POST['term']) && $_POST['term']!="")
                {
                    //Check if the term already exists, if not, insert it. If yes, but has been deleted, "undelete" it.
                    $sql="SELECT ID, Is_deleted FROM thesaurus_term WHERE Term='".$_POST['term']."' AND Domain='".$_POST['domain']."'";
                    $result = db_query($db, $sql);
                    $num_rows = mysqli_num_rows($result);
                    if($num_rows==0)
                    {
                        $sql="INSERT INTO thesaurus_term (ID, Term, Domain) VALUES ('', '".$_POST['term']."', '".$_POST['domain']."')";
                        db_query($db, $sql);
                        $id=mysqli_insert_id($db);
                    }
                    else
                    {
                        $data=db_fetch_assoc($result);
                        $id=$data['ID'];
                        if($data['Is_deleted']==1)
                        {
                            $sql="UPDATE thesaurus_term SET Is_deleted=0 WHERE ID=".$id;
                            db_query($db, $sql);
                        }
                    }
                    //Delete the unwanted relationships
                    //$_POST['relationship'] is an array that contains the ids of the terms in the relationships
                    // the user wants to delete in the format id1_id2
                    if(isset($_POST['relationship']) && !empty($_POST['relationship']))
                    {
                        foreach($_POST['relationship'] as $key=>$relationship)
                        {
                            $ids=explode('_', $relationship);
                            $sql="UPDATE thesaurus_relationship SET Is_deleted=1 WHERE ID_term1=".$ids[0]." AND ID_term2=".$ids[1];
                            db_query($db, $sql);
                        }
                    }
                }
                //Delete a term
                //$_POST['delete'] contains the id of a term that the user has deleted
                // by clicking the DELETE button in edit_thesaurus.php
                //NB: the relationships involving this term are kept intact
                if(isset($_POST['delete']) && $_POST['delete']!="")
                {
                    $sql="UPDATE thesaurus_term SET Is_deleted=1 WHERE ID=".$_POST['delete'];
                    db_query($db, $sql);
                }
                
                //Inserts or updates the relationships entered by the user
                for($i=1; $i<= 5; $i++)
                {
                    if(isset($_POST['term'.$i]) && !empty($_POST['term'.$i]) && isset($_POST['rel'.$i]) && !empty($_POST['rel'.$i]))
                    {
                         /*1: Check if the related term exists in the thesaurus. If yes: get its id, if no add it and get the id
                         * 2: Check if this relationship or the reverse already exists in thesaurus. If yes, update. If no, add it.
                         */
                        $sql="SELECT ID, Is_deleted FROM thesaurus_term WHERE Term='".$_POST['term'.$i]."'";
                        $result = db_query($db, $sql);
                        $num_rows = mysqli_num_rows($result);
                        if($num_rows==0)
                        {
                            //echo'not in thesaurus';
                            $sql="INSERT INTO thesaurus_term (ID, Term, Domain) VALUES ('', '".$_POST['term'.$i]."', '".$_POST['domain']."')";
                            db_query($db, $sql);
                            $id_rel_term=mysqli_insert_id($db);
                        }
                        else
                        {
                            //echo'in thesaurus';
                            $data=db_fetch_assoc($result);
                            $id_rel_term=$data['ID'];
                            if($data['Is_deleted']==1)
                            {
                                $sql="UPDATE thesaurus_term SET Is_deleted=0 WHERE ID=".$id_rel_term;
                                db_query($db, $sql);
                            }
                        }

                        $sql="SELECT * FROM thesaurus_relationship WHERE (ID_term1=".$id." AND ID_term2=".$id_rel_term.") OR (ID_term2=".$id." AND ID_term1=".$id_rel_term.")";
                        $result = db_query($db, $sql);
                        $num_rows = mysqli_num_rows($result);

                        if($num_rows==0)
                        {
                            //echo'add';
                            $sql="INSERT INTO thesaurus_relationship (ID_term1, ID_term2, Relationship) VALUES (".$id.", ".$id_rel_term.", '".$_POST['rel'.$i]."')";
                            db_query($db, $sql);
                        }
                        else
                        {
                            //echo'update';
                            $sql="UPDATE thesaurus_relationship SET Relationship='".$_POST['rel'.$i]."', Is_deleted=0 WHERE (ID_term1=".$id." AND ID_term2=".$id_rel_term.")";
                            $sql2="UPDATE thesaurus_relationship SET Relationship='".$invert_relationship[$_POST['rel'.$i]]."', Is_deleted=0 WHERE (ID_term2=".$id." AND ID_term1=".$id_rel_term.")";
                            db_query($db, $sql);
                            db_query($db, $sql2);
                        }
                    }
                }
            }
            
            //Display of the 3 thesauri
            
            //Definition of the three thesauri (domains) to be displayed
            $domains=array();
            $domains[]="types";
            $domains[]="materials";
            $domains[]="dates";
            
            //Definition of the field to be displayed (only Term)        
            $fields=array();
            $fields[]="Term";
            
            //Display of a table of terms for each thesaurus
            foreach ($domains as $key => $category)
            {
                echo"<h2>Thesaurus of ".$category."</h2>";
                echo"<form method='get' action='edit_thesaurus.php' enctype='multipart/form-data'>
                <input type='hidden' name='domain' value='".$category."'/>
                <input type='submit' value='Add term'>
                </form>";
                
                echo"<h3>List of terms:</h3>";
                
                $sql="SELECT ID, Term FROM thesaurus_term WHERE Domain='".$category."'AND Is_deleted=0";
                display_table($db, $sql, $fields, "thesaurus_term", false, "thesaurus", 0);
                
                echo"<br><hr><br>";
            }
            
            db_close($db);
            ?>
	</div>
    </div>
    <?php include '../footer.php'; ?>
</body>
</html>
