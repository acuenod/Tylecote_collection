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
            <table>
            <tr>
            <th>%Cu</th><th>%Sn</th><th>%Pb</th><th>%Zn</th><th>%As</th><th>%Sb</th><th>%Ag</th><th>%Ni</th><th>%Co</th><th>%Bi</th><th>%Fe</th><th>%Au</th><th>%Si</th>
            </tr>
            <tr>
            <td><input type="text" name="Cu" size="5"/></td><td><input type="text" name="Sn" size="5"/></td><td><input type="text" name="Pb" size="5"/></td><td><input type="text" name="Zn" size="5"/></td><td><input type="text" name="Arsenic" size="5" /></td><td><input type="text" name="Sb" size="5"/></td><td><input type="text" name="Ag" size="5"/></td><td><input type="text" name="Ni" size="5"/></td><td><input type="text" name="Co" size="5"/></td><td><input type="text" name="Bi" size="5" /></td><td><input type="text" name="Fe" size="5"/></td><td><input type="text" name="Au"size="5" /></td><td><input type="text" name="Si" size="5"/></td>
            </tr>
            <tr>
            <th>%C</th><th>%Mn</th><th>%P</th><th>%S</th><th>%Cr</th><th>%Ca</th><th>%O</th><th>%Cd</th><th>%Al</th><th>%Mg</th><th>%K</th><th>%Ti</th><th>%Se</th><th>%Cl</th>
            </tr>
            <tr>
            <td><input type="text" name="C" size="5"/></td><td><input type="text" name="Mn" size="5"/></td><td><input type="text" name="P" size="5"/></td><td><input type="text" name="S" size="5" /></td><td><input type="text" name="Cr" size="5"/></td><td><input type="text" name="Ca" size="5"/></td><td><input type="text" name="O" size="5"/></td><td><input type="text" name="Cd" size="5"/></td><td><input type="text" name="Al" size="5"/></td><td><input type="text" name="Mg" size="5"/></td><td><input type="text" name="K" size="5"/></td><td><input type="text" name="Ti" size="5"/></td><td><input type="text" name="Se" size="5"/></td><td><input type="text" name="Cl" size="5"/></td>
            </tr>
            </table>

            Further description and comments: </br>
            <textarea name="Comment" rows="5" cols="45">
            </textarea> </br>
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
