<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Advanced Search</title>
<link rel="stylesheet" href="mystyle.css">
</head>


<body>
    <div id="content">
        <?php include 'header.php'; ?>
        <div id="wrapper">
            <h1>Search the database</h1>

            <?php include 'functions/db_connect.php'; ?>
            
            Enter one or several keywords you would like to search for.<br>
            This will search for matches in four categories of entries: Objects, Samples, Publications and Micrographs.<br>
            <br>
            
            <form method="post" action="<?php echo $path?>search_results.php" enctype="multipart/form-data" class="search">
                Search: <input type="text" name="search_text"/>
                <input type="submit" value="Go" />
            </form>
            
        </div>
    </div>
<?php include 'footer.php'; ?>
</body>
</html> 
