<?php
//Database functions



function db_connect()
{
    $config = parse_ini_file($_SERVER['DOCUMENT_ROOT']."/Tylecote_collection/config.ini");
    $db = mysqli_connect($config['db_host'], $config['db_username'], $config['db_password'], $config['db_name']);
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