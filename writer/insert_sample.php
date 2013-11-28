<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Insert new sample</title>
<link rel="stylesheet" href="../mystyle.css">
</head>


<body>
    <div id="content">
        <?php include '../header.php'; ?>
        <div id="wrapper">

            <h1>Insert a new sample</h1>

            <h2>Sample details</h2>

            <form method="post" action="add.php" enctype="multipart/form-data" class="form">
                Sample type: <input type="text" name="Sample_type"> </br>
                </br>
                Sample number: <input type="text" name="Sample_nb"> </br>
                </br>
                Material: <input type="text" name="Sample_material"> </br>
                </br>
                Condition: <input type="text" name="Sample_condition"> </br>
                </br>
                Date sampled: <input type="text" name="Date_sampled"> </br>
                </br>
                Object part: <input type="text" name="Object_part"> </br>
                </br>
                Section: <input type="text" name="Section"> </br>
                </br>
                Collection: <input type="text" name="Collection"> </br>
                </br>
                Tylecote's notebook number: <input type="text" name="Tylecote_notebook"> </br>
                </br>
                Drawer: <input type="text" name="Drawer"> </br>
                </br>
                Date repolished: <input type="text" name="Date_repolished"> </br>
                </br>
                New drawer: <input type="text" name="Location_new_drawer"> </br>
                </br>
                New drawer code: <input type="text" name="Location_new_code"> </br>
                </br>

                <h3> Illustrations </h3></br>
                Upload a photo:
                <input type="file" name="Photo" /></br>
                </br>
                Upload a drawing:
                <input type="file" name="Drawing" /></br>
                </br>

                Further description and comments: </br>
                <textarea name="Comment" rows="5" cols="45"></textarea> </br>
                </br>
                <input type="hidden" name="class" value="sample">
                <?php
                    if(isset($_GET['id_object']))
                    {
                        $ID_object=$_GET['id_object'];
                        echo'<input type="hidden" name="ID_object" value='.$ID_object.' />';
                    }
                ?>
                <input type="submit" value="Add Sample">
                </br>
                </br>
            </form>
            
        </div>
    </div>
<?php include '../footer.php'; ?>
</body>
</html> 