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

            <h1>Insert a new micrograph</h1>

            <form method="post" action="add.php" enctype="multipart/form-data" class="form">
                Upload a micrograph:
                <input type="file" name="File" /></br>
                </br>
                Description: </br>
                <textarea name="Description" rows="5" cols="45">
                </textarea> </br>
                </br>
                Magnification: <input type="text" name="Magnification"/> </br>
                </br>
                Figure number: <input type="text" name="Fig_nb"/> </br>
                </br>

                <?php
                    $id=$_GET['id'];
                    $id_metallo=$_GET['id_metallo'];
                    echo"<input type='hidden' name='ID_object' value=".$id." />";
                    echo"<input type='hidden' name='ID_metallography' value=".$id_metallo." />";
                    display_linked($id, "object", "radio");
                ?>

                <input type="hidden" name="class" value="micrograph" />
                <input type="submit" value="Add micrograph" />
                </br>
                </br>
            </form>

        </div>
    </div>
<?php include '../footer.php'; ?>
</body>
</html> 

