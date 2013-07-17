
<?php
//Database functions

// To be changed when changing db name, login and password
/*function db_connect()
{
	$db = mysql_connect('127.0.0.1', 'root', '')or die('Erreur de connexion '.mysql_error());
	mysql_select_db('tylecote_data',$db)  or die('Erreur de selection '.mysql_error());
}*/

function db_connect()
{
    $db = mysqli_connect('127.0.0.1', 'root', '', 'tylecote_data');
    //Check connection
    if (mysqli_connect_errno())
    {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    return $db;
}

function db_query($db, $sql)
{
    $result=mysqli_query($db, $sql) or die('Erreur SQL !<br>'.$sql.'<br>'.mysqli_error($db));
    return $result;
}

function db_fetch_assoc($result)
{
    return mysqli_fetch_assoc($result);
}

function db_fetch_row($result)
{
    return mysqli_fetch_row($result);
}

function db_close($db)
{
    mysqli_close($db);
}
?>