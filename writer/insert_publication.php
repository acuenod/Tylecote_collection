<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Insert new publication</title>
<link rel="stylesheet" href="../mystyle.css">
</head>


<body>
    <div id="content">
        <?php include '../header.php'; ?>
        <div id="wrapper">

            <h1>Insert a new publication</h1>

            <h2>Publication details</h2>

            <form method="post" action="add.php" enctype="multipart/form-data" class="form">
                <div id="grey_text">Please enter the author list in the following format: Tylecote, R.F. and Gilmour, B.J.J.</div>
                Author: <input type="text" name="Author" size="50"/> </br>
                </br>Date: <input type="text" name="Date" /> </br>
                </br>Title: <input type="text" name="Title" size="50"/> </br>
                </br>Journal: <input type="text" name="Journal" size="50"/> </br>
                </br>Volume: <input type="text" name="Volume" /> </br>
                </br>Issue: <input type="text" name="Issue" /> </br>
                </br>Book title: <input type="text" name="Book_title" size="50"/> </br>
                </br>Editor: <input type="text" name="Editor" size="50"/> </br>
                </br>City: <input type="text" name="City" /> </br>
                </br>Publisher: <input type="text" name="Publisher" size="50"/> </br>
                </br>Pages: <input type="text" name="Page" /> </br>
                </br>Find it in oxford?: <input type="text" name="Oxf_location" /> </br>
                </br>Further description and comments: </br>
                <textarea name="Comment" rows="5" cols="45"></textarea> </br>
                </br>
                Upload a pdf:
                <input type="file" name="Pdf" /></br>
                </br>
                <input type="hidden" name="class" value="publication" />
                <input type="submit" value="Add Publication" />
                </br>
                </br>
            </form>

        </div>
    </div>
    <?php include '../footer.php'; ?>
</body>
</html> 