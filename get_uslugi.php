<?php
include_once 'config.php';
$find = $_GET['find'];
$r_ar = array();
$find = str_replace (" " , "%" , $find);
$sql_nomenklatura=mysqli_query ($dbcnx,"SELECT * FROM nomenklatura WHERE (text LIKE '%$find%' OR kod LIKE '%$find%') AND vid!='' ORDER BY text LIMIT 20");
while($nomenklatura=mysqli_fetch_array($sql_nomenklatura))
{

	$r_ar[] = array('id'=>$nomenklatura[id], 'kod'=>$nomenklatura[kod], 'name'=>$nomenklatura[text]);
}
$result = array('type'=>'success', 'r_ar'=>$r_ar); 
print json_encode($result);

?>