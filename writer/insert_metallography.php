<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Insert new metallography</title>
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

            <h1>Insert a new metallography</h1>

            <form method="post" action="add.php" enctype="multipart/form-data" class="form">
                Object Part: <input type="text" name="Object_part"/> </br>
                </br>
                Technology - brief summary:</br>
                <div id="grey_text">ex:"As-cast", "Cold-worked after annealing", "Forged and quench-hardened"</div>
                <textarea name="Technology" rows="1" cols="45"></textarea> </br>
                <input type="checkbox" name="Use_techno" value="Yes" /> Use this summary for the description of the object?</br>
                <div id="grey_text">(This will overwrite any previously selected summaries)</div>
                </br>
                Hardness (HV): <input type="text" name="HV"/> </br>
                </br>
                Hardness (HB): <input type="text" name="HB"/> </br>
                </br>
                Report: </br>
                <textarea name="Report" rows="5" cols="45"></textarea> </br>
                </br>
                Date of metallography: <input type="text" name="Date_metallo"/> </br>
                </br>
                Analyst: <input type="text" name="Analyst"/> </br>
                </br>
                Further description and comments: </br>
                <textarea name="Comment" rows="5" cols="45"></textarea> </br>
                </br>
                <?php
                    $id=$_GET['id'];
                    echo"<input type='hidden' name='ID_object' value=".$id." />";
                ?>

                <input type="hidden" name="class" value="metallography" />
                <input type="submit" value="Add metallography" />
                </br>
                </br>
            </form>

        </div>
    </div>
<?php include '../footer.php'; ?>
</body>
</html> 
