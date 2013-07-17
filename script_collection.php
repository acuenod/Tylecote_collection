<?php

include 'functions/db_connect.php';

db_connect();

$sql='UPDATE sample SET Collection="Tylecote" WHERE ID <154';
mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());
   
echo'Tylecote done';

$sql='UPDATE sample SET Collection="Coghlan" WHERE ID >153';
mysql_query($sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysql_error());

echo'Coghlan done';
?>
