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
            samples catalogued in this website, alongside notes on sites Tylecote visited,
            his smelting experiments and conferences he attended. Digitised copies of the relevant notebooks can be 
            viewed and downloaded by clicking on the links below (files named Tyl_notebook_01 to 102).<br>
            <br>
            The archive also includes three typewritten indexes detailing the contents of the notebooks.
            These can also be downloaded below (files named Tyl_index_103 to 105).<br>
            <br>
            Finally, Tylecote wrote a masterlist of the mounts in his collection. At the back of this handwritten
            book, there is also an alphabetical index giving mount numbers for a list of sites and projects. 
            This list is kept at the RLAHA in Oxford and a digital copy is available below
            (file name Tyl_masterlist_and_index).<br>
            <br>
            NB: The pencil notes might be difficult to read on certain screens. If this is the case,
            dropping the brightness of the screen should make it better. 
            <br>
           
            <br>
            <br>
            
        <?php
        $array=scandir(getcwd().'/notebooks/');
        foreach($array as $filename)
        {
            if ($filename!= "." && $filename!= "..")
            {
                echo "- <a href=notebooks/".$filename.">".$filename."</a><br>";
            }
        }
        
        ?>
        <br>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html> 