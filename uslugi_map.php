<?php
if (isset($_GET['usluga']) && is_numeric($_GET['usluga'])) $usluga = $_GET['usluga']; else $usluga = NULL;
header('Content-Type: application/json');
require_once ("config.php");
$i=0;
echo '{"type":"FeatureCollection","features":[';

	$sql_nomenklatura=mysqli_query ($dbcnx,"SELECT * FROM nomenklatura WHERE id=$usluga");
	while($nomenklatura=mysqli_fetch_array($sql_nomenklatura))
	{

		$query = "SELECT hospitals.id AS id, hospitals.name AS name, hospitals.mode AS mode, hospitals.phone_header AS phone_header, hospitals_nomenklatura.price AS price, hospitals_nomenklatura.oms AS oms, hospitals_nomenklatura.comments AS comments, hospitals_nomenklatura.hospitals_id AS h_id, hospitals.coordinaty AS coordinaty, hospitals.city AS city, hospitals.street AS street, hospitals.house_number AS house_number
		FROM hospitals, hospitals_nomenklatura
		WHERE hospitals.id=hospitals_nomenklatura.hospitals_id AND hospitals_nomenklatura.nomenklatura_id='$usluga'";
		$sql_uchr = mysqli_query ($dbcnx, $query);
		while($uchr=mysqli_fetch_array($sql_uchr))
		{
			$coord = explode(", ", $uchr[coordinaty]);
			if ($i!=0) echo ",";
			$name = addslashes($uchr[name]);
			$address = addslashes("<strong>Адрес:</strong> $uchr[city] $uchr[street] $uchr[house_number]");
			$usl = "<br>$nomenklatura[text] - <strong>$uchr[price]</strong> рублей"; if ($uchr[oms]) $usl = $usl."<br> Можно сделать по <strong>ОМС</strong>";
			$time_work = addslashes("<strong>Тел:</strong> $uchr[phone_header]<br><strong>Время работы:</strong> $uchr[mode]");
			$link = addslashes('<a href="http://elop.ru?uchr='.$uchr[id].'">'.$uchr[name].'</a>');
			echo'{"type":"Feature","id":"'.$i.'","geometry":{"type":"Point","coordinates":['.$coord[1].','.$coord[0].']},"properties":{"balloonContentHeader":"'.$link.'","balloonContentBody":"'.$address.$usl.'","balloonContentFooter":"'.$time_work.'","clusterCaption":"'.$name.'","hintContent":"'.$name.'"}}';
			$i++;

		}
	}




// $query = "SELECT * FROM hospitals ORDER BY full_name";
	// $sql_uchr = mysqli_query ($dbcnx, $query);
	// while($uchr=mysqli_fetch_array($sql_uchr))
	// {
		// $coord = explode(", ", $uchr[coordinaty]);
		// if ($i!=0) echo ",";
		// $address = addslashes("$uchr[type_object]<br> <strong>Адрес:</strong> $uchr[city] $uchr[street] $uchr[house_number] <br> <strong>Тел:</strong> $uchr[phone_header]");
		// $time_work = addslashes("<strong>Время работы:</strong> $uchr[mode]");
		// $link = addslashes('<a href="http://elop.ru?uchr='.$uchr[id].'">'.$uchr[name].'</a>');
		// echo'{"type":"Feature","id":"'.$i.'","geometry":{"type":"Point","coordinates":['.$coord[1].','.$coord[0].']},"properties":{"balloonContentHeader":"'.$link.'","balloonContentBody":"'.$address.'","balloonContentFooter":"'.$usluga.'","clusterCaption":"'.$usluga.'","hintContent":"'.$usluga.'"}}';
		// $i++;
	// }
//echo'{"type":"Feature","id":"0","geometry":{"type":"Point","coordinates":[55.831903,37.411961]},"properties":{"balloonContentHeader":"1","balloonContentBody":"2","balloonContentFooter":"3","clusterCaption":"4","hintContent":"5"}},';
//echo'{"type":"Feature","id":"1","geometry":{"type":"Point","coordinates":[55.832913,37.415971]},"properties":{"balloonContentHeader":"1","balloonContentBody":"2","balloonContentFooter":"3","clusterCaption":"4","hintContent":"5"}}';

echo ']}';
?>