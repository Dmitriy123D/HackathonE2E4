<?php
include_once 'config.php';
$find = $_GET['find'];
$r_ar = array();
$find = str_replace (" " , "%" , $find);
$sql_uchr=mysqli_query ($dbcnx,"SELECT * FROM hospitals WHERE full_name LIKE '%$find%' OR name LIKE '%$find%' ORDER BY full_name LIMIT 20");
while($uchr=mysqli_fetch_array($sql_uchr))
{
	//echo $uchr[name], "</br>";
	$address = "Адрес: ".$uchr[city]." ".$uchr[street]." ".$uchr[house_number];
	$r_ar[] = array('id'=>$uchr[id], 'name'=>$uchr[full_name], 'address'=>$address);
}
$result = array('type'=>'success', 'r_ar'=>$r_ar); 
print json_encode($result);

?>