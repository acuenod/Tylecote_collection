<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Edit glossary</title>
<link rel="stylesheet" href="../mystyle.css">
</head>


<body>
    <div id="content">
	<?php 
          include '../header.php'; 
          include '../functions/db_connect.php';
          $db=db_connect();
        ?>

	<div id="wrapper">
            
           <?php
           //Deals with the content of the form if we come from edit_glossary.php
            if(isset($_POST) && !empty($_POST))
            {
                //If the form to add a new term is filled in, check if the term already exists.
                //If not insert it. If yes, or if the term is left blank display an alert.
                if(isset($_POST['glossary_term']) && !empty($_POST['glossary_term']))
                {
                    $term=mysqli_real_escape_string($db, $_POST['glossary_term']);
                    $sql="SELECT ID FROM glossary WHERE Term='".$term."' AND Is_deleted=0";
                    $result=db_query($db, $sql);
                    $num_rows = mysqli_num_rows($result);
                    if($num_rows==0 && $_POST['glossary_definition']!='')
                    {
                        $definition= mysqli_real_escape_string($db, $_POST['glossary_definition']);
                        $sql = "INSERT INTO glossary (ID, Term, Definition) VALUES('', '".$term."', '".$definition."')";
                        db_query($db, $sql);
                        echo "New term successfully added <br>";
                    }
                    elseif($num_rows!=0){
                        echo'<script language="JavaScript"> alert("This term is already in use, please enter another term or update an existing one"); </script>';
                    }
                    elseif($_POST['glossary_definition']==''){
                        echo'<script language="JavaScript"> alert("Defintion cannot be left empty"); </script>';
                    }
                }
                //Deletes a current term
                if(isset($_POST['delete']) && !empty($_POST['delete']))
                {
                    foreach($_POST['delete'] as $ID => $delete)
                    {
                        $sql="UPDATE glossary SET Is_deleted=1 WHERE ID=".$ID;
                        db_query($db, $sql);
                    }
                    echo "Term(s) successfully deleted <br>";
                }
                //Updates the definition of a current term
                if(isset($_POST['update_glossary_definition']) && !empty($_POST['update_glossary_definition']))
                {
                    foreach($_POST['update_glossary_definition'] as $ID => $updated_def)
                    {
                        $updated_def=mysqli_real_escape_string($db, $updated_def);
                        $sql="UPDATE glossary SET Definition='".$updated_def."' WHERE ID=".$ID;
                        db_query($db, $sql);
                    }
                    echo "Definition(s) successfully updated <br>";
                }
           }
            ?>
            <!--Displays the form to create a new glossary term, or update the definition of a current term or delete a current term-->
            
                <h3>Add a new term</h3>
                <br>
                <form method="post" action="edit_glossary.php" enctype="multipart/form-data" autocomplete="off">
                    Term: <input type="text" name="glossary_term" /> </br>
                    <br>
                    Definition:<br>
                    <textarea name="glossary_definition" rows="5" cols="45"></textarea></br>
                    <br>
                    <input type="submit" value="Add term">
                </form> 
                <br>
                <br>
            
                <h3>Modify an existing definition</h3>
                <form method="post" action="edit_glossary.php" enctype="multipart/form-data" class="normal" autocomplete="off">
                    <table>
                        <tr><th>Delete?</th><th>Term</th><th>Definition</th><th>Added date</th></tr>
                        <?php 
                        $sql="SELECT ID, Term, Definition, Date_added FROM glossary WHERE Is_deleted=0 ORDER BY Term ASC";
                        $result = db_query($db, $sql);
                        while($data=db_fetch_assoc($result))
                        {
                            echo"<tr><td><input type='checkbox' name='delete[".$data['ID']."]' value='delete'></td>
                                <td>".$data['Term']."</td>
                                <td><textarea name='update_glossary_definition[".$data['ID']."]' rows='3' cols='70'>".$data['Definition']."</textarea><br></td>
                                <td>".$data['Date_added']."</td>
                                </tr>";
                        }
                        db_close($db);
                        ?>
                    </table>
                    <br>
                    <input type="submit" value="Update glossary">
                </form>
            
	</div>
    </div>
    <?php include '../footer.php'; ?>
</body>
</html>

