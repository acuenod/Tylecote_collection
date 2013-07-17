<?php 
$currentFile = $_SERVER["PHP_SELF"];
$parts = Explode('/', $currentFile);
$filename=$parts[count($parts) - 1];
$parent_file=$parts[count($parts) - 2];
if($filename!="start_session.php")
{
    session_start();
}
if($parent_file!="Tylecote_collection")
{
     $path="../";
}
else $path="";
if($filename=="logout.php")
{   
    session_unset();
    session_destroy();
}
else
{
    if($parent_file=="writer" && (!isset($_SESSION["access"])|| $_SESSION["access"]<2))
    {
        header("location:../login.php");
        exit;
    }
    elseif($parent_file=="admin" && (!isset($_SESSION["access"])|| $_SESSION["access"]<3))
    {
        header("location:../login.php");
        exit;
    }
    elseif($parent_file=="Tylecote_collection" && $filename!="login.php" && (!isset($_SESSION["access"])|| $_SESSION["access"]<1))
    {
        header("location:login.php");
        exit;
    }
}
?>

<div id="header">
    <div id="headerBox">
        <div id="headerTop">
            <?php
            if(!isset($_SESSION) || empty($_SESSION))
            {
                echo"<a href='".$path."login.php'>Sign in</a>";
            }
            else 
            {
                echo"Hello ".$_SESSION['username']."<br>";
                echo"<a href='".$path."logout.php'>Logout</a>";
            }
            ?>
        </div>
        Tylecote Coghlan collection of metallurgical samples
    </div>
</div>
<div id="menu">
    <div id="menuBox">
    <?php include 'nav.php'; ?>
    <?php include 'search.php'; ?>
    </div>
</div>
