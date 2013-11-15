<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Notebooks </title>
<link rel="stylesheet" href="mystyle.css">
</head>


<body>
    <div id="content">
        <?php include 'header.php'; ?>
        <div id="wrapper">

            <h1>Tylecote's notebooks</h1>
           
            In 2008, the <a href="http://hist-met.org/">Historical Metallurgy Society</a>
            acquired the papers of Professor Tylecote. These are currently being catalogued by the HMS
            and are archived in Ironbridge. The notebooks include many notes on the metallurgical
            samples catalogued in this website. Digitised copies of the relevant notebooks can be 
            viewed and downloaded by clicking on the links below.<br>
            <br>
            NB: The pencil notes might be difficult to read on certain screens. If this is the case,
            dropping the brightness of the screen should make it better. 
            <br>
           
            <br>
            <br>
            
        <?php
        //Open the notebooks folders and displays a clickable list of all the notebooks
        if($handle = opendir(getcwd().'/notebooks/'))
        {
            //Loop over the directory
            while (false !== ($entry = readdir($handle)))
            {
                if ($entry != "." && $entry != "..")
                {
                    echo "- <a href=notebooks/".$entry.">".$entry."</a><br>";
                }
            }
            
            closedir($handle);
        }
        ?>
        <br>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html> 