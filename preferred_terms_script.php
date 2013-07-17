<?php

include 'functions/db_connect.php';

$db=db_connect();

$sql = "SELECT T2.Term AS Non_pref,
    T1.Term AS Pref
    FROM thesaurus_term AS T2 
    INNER JOIN thesaurus_relationship AS R ON T2.ID = R.ID_term2 
    INNER JOIN thesaurus_term AS T1 ON T1.ID = R.ID_term1 
    WHERE T1.Is_deleted=0 AND T2.Is_deleted=0 AND R.Is_deleted=0 
        AND (R.relationship='Use For')";
$result = db_query($db, $sql);
while($data=db_fetch_assoc($result))
{ 
    $sql="UPDATE object SET Material = '".$data['Pref']."' WHERE Material = '".$data['Non_pref']."'";
    db_query($db, $sql);
}


$sql = "SELECT T2.Term AS Non_pref,
    T1.Term AS Pref
    FROM thesaurus_term AS T2
    INNER JOIN thesaurus_relationship AS R ON T2.ID=R.ID_term1
    INNER JOIN thesaurus_term AS T1 ON T1.ID = R.ID_term2
    WHERE T1.Is_deleted=0 AND T2.Is_deleted=0 AND R.Is_deleted=0
    AND R.relationship='Use'";
$result = db_query($db, $sql);
while($data=db_fetch_assoc($result))
{ 
    print_r($data);
    $sql="UPDATE object SET Material = '".$data['Pref']."' WHERE Material = '".$data['Non_pref']."'";
    db_query($db, $sql);
}

?>
