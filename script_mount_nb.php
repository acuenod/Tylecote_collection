<?php
// Script that goes through all the name of samples in the database and renames them to 
// add the three letters code in front on the number if it isn't already there
set_time_limit(0);

include 'functions/db_connect.php';

$db=db_connect();
$sql="SELECT ID, Sample_nb, Collection FROM sample WHERE Is_deleted=0";
$result = db_query($db, $sql);
while($data= db_fetch_assoc($result))
{
   
    if ($data['Collection']=='Tylecote' && !preg_match('/^Tyl/', $data['Sample_nb']))
    {
       $sql2="UPDATE sample SET Sample_nb='Tyl_".$data['Sample_nb']."' WHERE ID=".$data['ID'];
       db_query($db, $sql2);
    }
    elseif ($data['Collection']=='Coghlan' && !preg_match('/^Cog/', $data['Sample_nb']))
    {
        $sql2="UPDATE sample SET Sample_nb='Cog_".$data['Sample_nb']."' WHERE ID=".$data['ID'];
        db_query($db, $sql2);
    }    
}
echo"Done changing sample names";
db_close($db);

?>
