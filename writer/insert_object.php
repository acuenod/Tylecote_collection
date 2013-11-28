<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Insert new object</title>
<link rel="stylesheet" href="../mystyle.css">
</head>


<body>
    <div id="content">
        <?php include '../header.php'; ?>
        <div id="wrapper">

            <h1>Insert a new object</h1>

            <h2>Object details</h2>


            <form method="post" action="add.php" enctype="multipart/form-data" class="form">
                Object type:<input type="text" name="Type"></br>
                </br>
                Description:</br>
                <textarea name="Description" rows="5" cols="45"></textarea></br>
                </br>
                Material: <input type="text" name="Material"> </br>
                </br>
                Site: <input type="text" name="Site">  
                County: <input type="text" name="County"> 
                Country: <input type="text" name="Country"> </br>
                </br>
                Date (stratigraphy): <input type="text" name="Date_strati">
                Date (typology): <input type="text" name="Date_typo"> </br>
                </br>
                Site period: <input type="text" name="Site_period">
                Site layer: <input type="text" name="Site_layer"> </br>
                </br>
                Museum: <input type="text" name="Museum"> </br>
                </br>
                Museum number: <input type="text" name="Museum_nb"> 
                Field number: <input type="text" name="Field_nb"> 
                Catalogue number: <input type="text" name="Catalogue_nb"> </br>
                </br>

                <h3> Dimensions </h3></br>
                <table>
                <tr>
                <th>Weight (g):</th><th>Length (mm):</th><th>Width (mm):</th><th>Thickness (mm):</th>
                </tr>
                <tr>
                <td><input type="text" name="Weight"></td><td><input type="text" name="Length"></td><td><input type="text" name="Width"></td><td><input type="text" name="Thickness"></td>
                </tr>
                </table>
                <table>
                <tr>
                <th>Base diameter (mm):</th><th>Max diameter (mm):</th>
                </tr>
                <tr>
                <td><input type="text" name="Base_diameter"></td><td><input type="text" name="Max_diameter"></td>
                </tr>
                </table>

                <h3> Illustrations </h3></br>
                Upload a photo:
                <input type="file" name="Photo"></br>
                </br>
                Upload a drawing:
                <input type="file" name="Drawing"></br>
                </br>
                Upload an index card (front):
                <input type="file" name="Card_scan_front"></br>
                </br>
                Upload an index card (back):
                <input type="file" name="Card_scan_back"></br>
                </br>

                Further description and comments: </br>
                <textarea name="Comment" rows="5" cols="45"></textarea> </br>
                </br>
                <input type="hidden" name="class" value="object">

                <?php
                    if(isset($_GET['id_sample']))
                    {
                        $ID_sample=$_GET['id_sample'];
                        echo'<input type="hidden" name="ID_sample" value='.$ID_sample.'>';
                    }
                ?>
                <input type="submit" value="Add Object">
                </br>
                </br>
            </form>

        </div>
    </div>
<?php include '../footer.php'; ?>
</body>
</html> 