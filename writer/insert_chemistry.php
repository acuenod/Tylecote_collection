<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Insert new chemistry</title>
<link rel="stylesheet" href="../mystyle.css">
</head>


<body>
    <div id="content">
        <?php include '../header.php'; ?>

        <div id="wrapper">
        <?php
        include '../functions/db_connect.php'; 
        include '../functions/display_linked.php'; 
        include '../globals.php';
        global $array_chemistry;
        ?>

        <h1>Insert a new chemical analysis</h1>

        <form method="post" action="add.php" enctype="multipart/form-data" class="form">
            Technique: <input type="text" name="Technique"/> </br>
            </br>
            Sampling method: <input type="text" name="Sampling_method"/> </br>
            </br>
            Number of runs: <input type="text" name="Nb_runs"/> </br>
            </br>
            Date analysed: <input type="text" name="Date_analysed"/> </br>
            </br>
            Lab: <input type="text" name="Lab"/> </br>
            </br>
            Object condition: <input type="text" name="Object_condition"/> </br>
            </br>
            Object part: <input type="text" name="Object_part"/> </br>
            </br>

            Composition:</br>
            
            <?php
            //Display of chemistry blocks
            for($i=1; $i<=3; $i++)
            {
                echo"<br>";
                echo"<table border=1 cellspacing=0 cellpadding=3 class='normal'>";
                echo"<tr>";
                foreach ($array_chemistry[$i] as $field)
                {
                    if ($field=="Arsenic") //Has to be done because "As" cannot be used as a column name as it has a particular meaning in SQL
                    {
                        echo "<th>%As</th>";
                    }
                    else
                    {
                        echo "<th>%".$field."</th>";
                    }
                }
                echo"</tr>";
                echo"<tr>";
                foreach ($array_chemistry[$i] as $field)
                {
                        echo "<td><input type='text' name=".$field." size='3'></td>";
                }
                echo"</tr>";
                echo"</table>";
            }
            ?>
            
            <br>
            Further description and comments: </br>
            <textarea name="Comment" rows="5" cols="45"></textarea></br>
            </br>
            <?php
                $id=$_GET['id'];
                echo"<input type='hidden' name='ID_object' value=".$id." />";
            ?>

            <input type="hidden" name="class" value="chemistry" />
            <input type="submit" value="Add chemistry" />
            </br>
            </br>
        </form>

        </div>
    </div>
<?php include '../footer.php'; ?>
</body>
</html> 
