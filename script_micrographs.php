<?php

include 'functions/db_connect.php';

db_connect();

$sql="SELECT ID, Micrograph, Img_2, Img_3 FROM metallography WHERE Is_deleted=0";
$result = mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
while($data=mysql_fetch_assoc($result))
{
    if($data['Micrograph']!="")
    {
        $sql="INSERT INTO micrograph (ID_metallography, File) VALUE (".$data['ID'].", '".$data['Micrograph']."')";
        mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    }
    if($data['Img_2']!="")
    {
        $sql="INSERT INTO micrograph (ID_metallography, File) VALUE (".$data['ID'].", '".$data['Img_2']."')";
        mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    }
    if($data['Img_3']!="")
    {
        $sql="INSERT INTO micrograph (ID_metallography, File) VALUE (".$data['ID'].", '".$data['Img_3']."')";
        mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
    }
}
echo'done'
?>
