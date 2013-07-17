<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/html4/loose.dtd">
<html>
<head>
<title>Browse database</title>
<link rel="stylesheet" href="mystyle.css">
</head>


<body>
<?php include 'header.php'; ?>
<div id="wrapper">

<?php 
include 'functions/db_connect.php';
?>


<?php



db_connect();

$list=array();

$sql = "SELECT Type FROM object WHERE Is_deleted=0";
$req = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data = mysql_fetch_assoc($req))
{
    if(!in_array($data['Type'], $list))
    {
        $list[]=$data['Type'];
        echo $data['Type']."<br>";
    }
}
 


 mysql_close();



?>

</div>
<?php include 'footer.php'; ?>
</body>
</html> 