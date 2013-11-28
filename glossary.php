<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Glossary</title>
<link rel="stylesheet" href="mystyle.css">
</head>


<body>
    <div id="content">
        <?php include 'header.php'; 
        include 'functions/db_connect.php';
        ?>
        <div id="wrapper">

            <h1>Glossary</h1>
            The main terms used to described the samples and their microstructures are defined here.<br>
            <br>
            <br>
            <table class='glossary'>
            
            <?php
            $db=db_connect();
            $sql="SELECT Term, Definition FROM glossary WHERE Is_deleted=0 ORDER BY Term ASC";
            $result = db_query($db, $sql);
            while($data=db_fetch_assoc($result))
            {
                echo"<tr><th>".$data['Term']."</th><td>".nl2br($data['Definition'])."</td></tr>";
            }
            ?>
            </table>
            <br>
            <br>
            <u>Sources:</u><br>
            <br>
            - Scott, D. A. (1991). <i>Metallography and microstructure of ancient and historic metals.</i> Getty Conservation Institute; J. Paul Getty Museum, in association with Archtype Books.<br>
            <br>
            - Chris Salter's webpage <a href="http://users.ox.ac.uk/~salter2/glossary/glos-a.html">(Visit page)</a>.<br>
            <br>
            - Hoyland, R. G., & Gilmour, B. J. (2006). <i>Medieval Islamic Swords and Swordmaking: Kindi's Treatise" On Swords and Their Kinds".</i> Gibb Memorial Trust.<br>
            <br>
            <?php db_close($db);?>
        <br>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html> 