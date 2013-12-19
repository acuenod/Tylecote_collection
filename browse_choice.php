<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Browse</title>
<link rel="stylesheet" href="mystyle.css">
</head>


<body>
    <div id="content">
        <?php include 'header.php'; ?>
        <div id="wrapper">

            <?php
            //First level of choice: Objects, Samples or Publications
            if(!isset($_GET['class']) || $_GET['class']=='')
            {
                echo"<h1>Browse collection</h1>";
                echo"<input type='button' name='goto_browse_object' value='Objects' onclick='self.location.href=\"browse.php?class=object\"'>
                    <input type='button' name='goto_browse_choice' value='Samples' onclick='self.location.href=\"browse_choice.php?class=sample\"'>
                    <input type='button' name='goto_browse_publication' value='Publications' onclick='self.location.href=\"browse.php?class=publication\"'>
                    <br>";
            }
            // Second level of choice for samples: Tylecote or Coghlan collection
            elseif($_GET['class']=="sample" && !isset($_GET['collection']))
            {
                echo"<h1>Browse samples</h1>";
                echo"Choose which collection you would like to browse.<br><br>";
                echo"<input type='button' name='goto_browse_coghlan' value='Coghlan' onclick='self.location.href=\"browse_choice.php?class=sample&collection=Coghlan\"'>
                <input type='button' name='goto_browse_tylecote' value='Tylecote' onclick='self.location.href=\"browse_choice.php?class=sample&collection=Tylecote\"'>
                <input type='button' name='goto_browse_morton' value='Morton' onclick='self.location.href=\"browse_choice.php?class=sample&collection=Morton\"'>
                <input type='button' name='goto_browse_gilmour' value='Gilmour' onclick='self.location.href=\"browse_choice.php?class=sample&collection=Gilmour\"'>";
            }
            // Third level of choice for samples: Which drawer
            elseif($_GET['class']=="sample" && isset($_GET['collection']) && $_GET['collection']!='')
            {
                echo"<h1>Browse samples</h1>";
                echo"<div id='go_back'><a href=\"browse_choice.php?class=sample\"'>< Back to collections</a></div>";
                echo"<h2>".$_GET['collection']." collection</h2>";
                if($_GET['collection']=="Coghlan")
                {                        
                    echo"<input type='button' name='goto_browse_coghlan' value='Drawer 1' onclick='self.location.href=\"browse.php?class=sample&collection=Coghlan&drawer=1\"'><br><br>
                        <input type='button' name='goto_browse_coghlan' value='Drawer 2' onclick='self.location.href=\"browse.php?class=sample&collection=Coghlan&drawer=2\"'><br><br>
                        <input type='button' name='goto_browse_coghlan' value='Drawer 3' onclick='self.location.href=\"browse.php?class=sample&collection=Coghlan&drawer=3\"'><br><br>
                        <input type='button' name='goto_browse_coghlan' value='Drawer 4' onclick='self.location.href=\"browse.php?class=sample&collection=Coghlan&drawer=4\"'><br><br>
                        <input type='button' name='goto_browse_coghlan' value='Drawer 5' onclick='self.location.href=\"browse.php?class=sample&collection=Coghlan&drawer=5\"'><br><br>
                        <input type='button' name='goto_browse_coghlan' value='Drawer 6' onclick='self.location.href=\"browse.php?class=sample&collection=Coghlan&drawer=6\"'><br><br>
                        <input type='button' name='goto_browse_coghlan' value='Drawer 7' onclick='self.location.href=\"browse.php?class=sample&collection=Coghlan&drawer=7\"'><br><br>
                        <input type='button' name='goto_browse_coghlan' value='Drawer 8' onclick='self.location.href=\"browse.php?class=sample&collection=Coghlan&drawer=8\"'><br><br>
                        <input type='button' name='goto_browse_coghlan' value='Drawer 9' onclick='self.location.href=\"browse.php?class=sample&collection=Coghlan&drawer=9\"'><br><br>
                        <input type='button' name='goto_browse_coghlan' value='Drawer 10' onclick='self.location.href=\"browse.php?class=sample&collection=Coghlan&drawer=10\"'>
                        ";
                }
                elseif($_GET['collection']=="Tylecote")
                {
                     echo"<input type='button' name='goto_browse_tylecote' value='Drawer 001-045' onclick='self.location.href=\"browse.php?class=sample&collection=Tylecote&drawer=001-045\"'><br><br>
                         <input type='button' name='goto_browse_tylecote' value='Drawer 046-070' onclick='self.location.href=\"browse.php?class=sample&collection=Tylecote&drawer=046-070\"'><br><br>
                         <input type='button' name='goto_browse_tylecote' value='Drawer 071-108' onclick='self.location.href=\"browse.php?class=sample&collection=Tylecote&drawer=071-108\"'><br><br>
                         <input type='button' name='goto_browse_tylecote' value='Drawer 109-150' onclick='self.location.href=\"browse.php?class=sample&collection=Tylecote&drawer=109-150\"'><br><br>
                         <input type='button' name='goto_browse_tylecote' value='Drawer 151-188' onclick='self.location.href=\"browse.php?class=sample&collection=Tylecote&drawer=151-188\"'><br><br>
                         <input type='button' name='goto_browse_tylecote' value='Drawer 189-238' onclick='self.location.href=\"browse.php?class=sample&collection=Tylecote&drawer=189-238\"'><br><br>
                         <input type='button' name='goto_browse_tylecote' value='Drawer 239-282' onclick='self.location.href=\"browse.php?class=sample&collection=Tylecote&drawer=239-282\"'><br><br>
                         <input type='button' name='goto_browse_tylecote' value='Drawer 283-314' onclick='self.location.href=\"browse.php?class=sample&collection=Tylecote&drawer=283-314\"'><br><br>
                         <input type='button' name='goto_browse_tylecote' value='Drawer 315-343' onclick='self.location.href=\"browse.php?class=sample&collection=Tylecote&drawer=315-343\"'><br><br>
                         <input type='button' name='goto_browse_tylecote' value='Drawer 344-372' onclick='self.location.href=\"browse.php?class=sample&collection=Tylecote&drawer=344-372\"'><br><br>
                         <input type='button' name='goto_browse_tylecote' value='Drawer 373-399' onclick='self.location.href=\"browse.php?class=sample&collection=Tylecote&drawer=373-399\"'><br><br>
                         <input type='button' name='goto_browse_tylecote' value='Drawer 400-435' onclick='self.location.href=\"browse.php?class=sample&collection=Tylecote&drawer=400-435\"'><br><br>
                         <input type='button' name='goto_browse_tylecote' value='Drawer 436-475' onclick='self.location.href=\"browse.php?class=sample&collection=Tylecote&drawer=436-475\"'><br><br>
                         <input type='button' name='goto_browse_tylecote' value='Drawer 476-512' onclick='self.location.href=\"browse.php?class=sample&collection=Tylecote&drawer=476-512\"'><br><br>
                         <input type='button' name='goto_browse_tylecote' value='Drawer 513-522' onclick='self.location.href=\"browse.php?class=sample&collection=Tylecote&drawer=513-522\"'><br><br>
                         ";
                }
                if($_GET['collection']=="Morton")
                {                        
                    echo"<input type='button' name='goto_browse_morton' value='Drawer 10' onclick='self.location.href=\"browse.php?class=sample&collection=Morton&drawer=10\"'><br><br>";
                }
            }
            ?>
        
        </div>
    </div>
<?php include 'footer.php'; ?>
</body>
</html> 