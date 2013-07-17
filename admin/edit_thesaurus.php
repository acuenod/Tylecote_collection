<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Edit thesaurus</title>
<link rel="stylesheet" href="../mystyle.css">
</head>

<script src='/Tylecote_collection/functions/navigation.js'></script>
<script src='/Tylecote_collection/functions/sorttable.js'></script>
<script language="JavaScript">
function confirm_delete()
{
    var answer = confirm ("Are you sure you want to delete this term?")
    if (answer)
    return true;
    else return false;
}
</script>

<body>
    <div id="content">
	<?php include '../header.php'; ?>
	<div id="wrapper">
            <h1>Add or edit thesaurus term</h1>
            <div id="centre">
                
                <?php
                include '../functions/db_connect.php';
                include '../functions/display_table.php';

                $db=db_connect();

                if(isset($_GET)) //Should always be true unless the URL was typed in directly
                {
                    if(!empty($_GET['domain'])) $domain=$_GET['domain']; //If we come from on the the Add buttons in thesauri.php
                    if(!empty($_GET['id'])) //If we come from clicking on the name of a term in thesauri.php or edit_thesaurus.php
                    {
                        //Get the name and domain of the term
                        $id=$_GET['id'];
                        $sql="SELECT Term, Domain FROM thesaurus_term WHERE ID=".$id." AND Is_deleted=0";
                        $result=db_query($db, $sql);
                        $data=db_fetch_assoc($result);
                        $term=$data['Term'];
                        $domain=$data['Domain'];
                    }
                    else $term="";
                }
                ?>
                <!--Displays (with possibility of edit) the name and domain of the term-->
                <form method="post" action="thesauri.php" enctype="multipart/form-data">
                    <table border=1 cellspacing=0 cellpadding=3 class="normal">
                        <tr><th>Term </th><th> <input type="text" name="term" value="<?php echo$term; ?>"/></th></tr>               
                        <tr><td>Domain </td><td> <select name="domain">
                        <?php echo'<option selected value="'.$domain.'">'.$domain.'</option>';?>
                        <option value="types">types</option>
                        <option value="materials">materials</option>
                        <option value="dates">dates</option>
                        </select></td></tr>
                    </table>
                    <br>

                    <?php
                    //Displays (with possibility of deletion) the relationships involving the term,
                    // unless we come from clicking on an ADD button
                    if(!empty($data))
                    {
                        echo"<h3>Existing relationships</h3>";
                        echo"You can delete a relationship by ticking the box next to it. This only deletes the relationship. It does not remove the terms for the thesaurus.<br><br>";
                        echo"<table border=1 cellspacing=0 cellpadding=3 class='sortable' width=100%>";
                        echo "<tr><th>Delete?</th><th onmouseover='ChangeColorHeader(this, true)' onmouseout='ChangeColorHeader(this, false)'>Term</th><th onmouseover='ChangeColorHeader(this, true)' onmouseout='ChangeColorHeader(this, false)'>Relationship</th></tr>";

                        $sql="SELECT ID_term2, Relationship, Term FROM thesaurus_relationship JOIN thesaurus_term ON ID_term2=ID WHERE ID_term1=".$id." AND thesaurus_relationship.Is_deleted=0 AND thesaurus_term.Is_deleted=0";
                        $result=db_query($db, $sql);
                        while($row=db_fetch_assoc($result))
                        {
                            echo "<tr onmouseover='ChangeColor(this, true)' onmouseout='ChangeColor(this, false)' class='normal' ><th><input type='checkbox' name='relationship[]' value='".$id."_".$row['ID_term2']."'></th><td onclick=DoNav('/Tylecote_collection/admin/edit_thesaurus.php?id=".$row['ID_term2']."');>".$row['Term']."</td><td onclick=DoNav('/Tylecote_collection/admin/edit_thesaurus.php?id=".$row['ID_term2']."');> ".$row['Relationship']."</td></tr>";
                        }

                        $invert_relationship=array();
                        $invert_relationship['Use For']="Use";
                        $invert_relationship['Use']="Use For";
                        $invert_relationship['NT']="BT";
                        $invert_relationship['BT']="NT";
                        $invert_relationship['RT']="RT";

                        $sql="SELECT ID_term1, Relationship, Term 
                            FROM thesaurus_relationship 
                            JOIN thesaurus_term ON ID_term1=ID 
                            WHERE ID_term2=".$id." AND thesaurus_relationship.Is_deleted=0 AND thesaurus_term.Is_deleted=0";
                        $result=db_query($db, $sql);
                        while($row=db_fetch_assoc($result))
                        {
                            echo "<tr onmouseover='ChangeColor(this, true)' onmouseout='ChangeColor(this, false)' class='normal' ><th><input type='checkbox' name='relationship[]' value='".$row['ID_term1']."_".$id."'></th><td onclick=DoNav('/Tylecote_collection/admin/edit_thesaurus.php?id=".$row['ID_term1']."');>".$row['Term']."</td> <td onclick=DoNav('/Tylecote_collection/admin/edit_thesaurus.php?id=".$row['ID_term1']."');>".$invert_relationship[$row['Relationship']]."</td></tr>";
                        }
                        echo"</table><br>";
                    }
                    db_close($db);
                    ?>
                    
                    <!--Displays the form to add new relationships, update old ones or restaure deleted ones-->
                    <h3>Add relationships</h3>
                    Caution: The relationships specified between two terms here will overwrite any pre-existing relationship between these two terms.
                    <br><br>
                    <table>
                        <?php
                        for($i=1; $i <= 5; $i++)
                        {
                            echo '<tr><td>
                            <select name="rel'.$i.'">
                            <option value="Use For">Use For</option>
                            <option value="Use">Use</option>
                            <option value="NT">NT</option>
                            <option value="BT">BT</option>
                            <option value="RT">RT</option>
                            </select></td>
                            <td><input type="text" name="term'.$i.'"></td>
                            </tr>';
                        }
                        ?>
                    </table>
                    <br>
                    <input type="submit" value="Update">
                 </form>
                 </br>
                 <?php
                    //Displays the Delete button (Deletes this term, but not his relationships)
                    if($term!="")
                    {
                        echo"<h3>Delete term ".$term."</h3>";
                        echo"<form method='post' enctype='multipart/form-data' class='form' action='thesauri.php' onsubmit='return confirm_delete()'>";
                        echo"NB: If you then re-enter this term at a later time, all of its previous relationships will be restored.<br><br>";
                        echo"<input type='hidden' name='delete' value='".$id."'>";
                        echo"<input type='submit' value='Delete'>";
                        echo"</form>";
                    }
                 ?>
            </div>
	</div>
    </div>
    <?php include '../footer.php'; ?>
</body>
</html>
