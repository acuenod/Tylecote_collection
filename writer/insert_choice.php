<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Insert new </title>
<link rel="stylesheet" href="../mystyle.css">
</head>


<body>
    <div id="content">
        <?php include '../header.php'; ?>
        <div id="wrapper">

            <h1>Insert new record</h1>

            <h2>What type of record do you want to enter?</h2>

            <input type='button' name='goto_insert_object' value='Object' onclick='self.location.href="insert_object.php"'>
            <input type='button' name='goto_insert_sample' value='Sample' onclick='self.location.href="insert_sample.php"'>
            <input type='button' name='goto_insert_publication' value='Publication' onclick='self.location.href="insert_publication.php"'>
            <br>

        </div>
    </div>
    <?php include '../footer.php'; ?>
</body>
</html> 