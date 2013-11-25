<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Advanced Search</title>
<link rel="stylesheet" href="mystyle.css">
</head>

 <!-- If the the writer has forgotten to enter some text, an alert is displayed -->
<script language="JavaScript">
function validateForm()
{
    var search_text=document.getElementById('search_text');
    if(search_text.value==null || search_text.value=="")
    {
        alert ("You must enter a search term!");
        return false;
    }
}
</script>

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
                Search: <input type="text" id="search_text" name="search_text"/>
                <input type="submit" value="Go" onClick="return validateForm()"/>
            </form>
            
        </div>
    </div>
<?php include 'footer.php'; ?>
</body>
</html> 
