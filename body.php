<?php

if ($uchr!=NULL && $edit==NULL) //Карточка учреждения
{
	?>
	<script src="https://api-maps.yandex.ru/2.1/?lang=ru_RU&amp;apikey=cf839dd8-9d68-4c97-84ad-d8135946d7cd" type="text/javascript"></script>
	<script src="js/map_tochka.js" type="text/javascript"></script>
	<?php

	$query = "SELECT * FROM hospitals WHERE id='$uchr'";
	$sql_uchr = mysqli_query ($dbcnx, $query);
	while($uchrejd=mysqli_fetch_array($sql_uchr))
	{
		echo "<div class='content'>";
		echo "<div class='content-body'>";
		echo "<h3>$uchrejd[name]</h3>";
		
		echo "<h6>$uchrejd[full_name]</h6>";
		echo "<span class='body-label'>Тип учреждения:</span> $uchrejd[type_object]<br>";
		echo "<span class='body-label'>Оказываемые услуги:</span> $uchrejd[list_services]<br>";
		echo "<span class='body-label'>Тел:</span> $uchrejd[phone_header]<br>";
		echo "<span class='body-label'>Веб:</span> <a href='http://$uchrejd[comments]'>$uchrejd[comments]</a><br>";
		echo "<span class='body-label'>Адрес:</span><span class='ymaps-geolink'> $uchrejd[city] $uchrejd[street] $uchrejd[house_number]</span><br>";
		echo "<span class='body-label'>Время работы:</span> $uchrejd[mode]<br>";
		echo "<div class='zapis'><a target='_blank' href='https://zapisnapriemrostov.ru/'>Записаться на прием</a></div>";
		echo "</div>";
		$coord = explode(", ", $uchrejd[coordinaty]);
		echo "<input type='hidden' id='coord1' value='$coord[1]'/>";
		echo "<input type='hidden' id='coord2' value='$coord[0]'/>";
		echo "<div id='map' class='content-map'></div>";
		$query = "SELECT nomenklatura.id AS id, nomenklatura.text AS name, nomenklatura.kod AS kod, hospitals_nomenklatura.price AS price, hospitals_nomenklatura.oms AS oms, hospitals_nomenklatura.comments AS comments
		FROM nomenklatura, hospitals_nomenklatura
		WHERE hospitals_nomenklatura.hospitals_id='$uchrejd[id]' AND hospitals_nomenklatura.nomenklatura_id=nomenklatura.id AND nomenklatura.vid!=''";
		echo '</div><table class="u-full-width">  <thead>
    <tr>
      <th>Код услуги</th>
      <th>Наименование</th>
      <th>Стоимость</th>
      <th>ОМС</th>
    </tr>
  </thead>
  <tbody>';
		$sql_nomenklatura = mysqli_query ($dbcnx, $query);
		while($nomenklatura=mysqli_fetch_array($sql_nomenklatura))
		{
			echo '<tr>';
			$link="<a href='index.php?usluga=$nomenklatura[id]'>$nomenklatura[name]</a>";
			echo "<td>$nomenklatura[kod]</td><td>$link $nomenklatura[comments]</td><td>$nomenklatura[price]</td><td>";
			if($nomenklatura[oms]>0) echo "ОМС";
			echo '</td></tr>';
		}
	echo '  </tbody></table>';	
		

		echo "<input type='hidden' id='name_uchr' value='$uchrejd[name]'/>";
		echo "<input type='hidden' id='address_uchr' value='$uchrejd[address]'/>";
		
	}
} elseif($uchr!=NULL && edit!=NULL) // Редактирование учреждения
{
	$query = "SELECT * FROM uchr WHERE id=$uchr";
	$sql_uchr = mysqli_query ($dbcnx, $query);
	while($uchrejd=mysqli_fetch_array($sql_uchr))
	{
		echo "<h3>$uchrejd[name]</h3>";
		echo "<strong>Тел:</strong> $uchrejd[tel]<br>";
		echo "<strong>Факс:</strong> $uchrejd[fax]<br>";
		if($uchrejd[email]) echo "<strong>e-mail:<strong> $uchrejd[email]<br>";
		echo "<strong>Веб:</strong> <a href='http://$uchrejd[web]'>$uchrejd[web]</a><br>";
		echo "<strong>Адрес:</strong><span class='ymaps-geolink'> г. $uchrejd[city], ул. $uchrejd[address]</span><br>";
		echo "<form method='POST' action='prov_form.php'>";
			require_once("nomenklatura.php");
			echo "<input type='hidden' id='id_uchr' name='id_uchr' value='$uchrejd[id]'>";
			echo "<p><input type='submit' id='submit'></p>";
		echo "</form>";
	}
} elseif($usluga!=NULL) // Редактирование учреждения
{
	?> 
	<script src="https://api-maps.yandex.ru/2.1/?lang=ru-RU&amp;apikey=cf839dd8-9d68-4c97-84ad-d8135946d7cd" type="text/javascript"></script>
	<?php
	echo "<input type='hidden' id='usluga' value='$usluga'/>";
	$sql_nomenklatura=mysqli_query ($dbcnx,"SELECT * FROM nomenklatura WHERE id=$usluga");
	while($nomenklatura=mysqli_fetch_array($sql_nomenklatura))
	{
		echo "<h1>$nomenklatura[kod] $nomenklatura[text]</h1>";
		?> <div id="map"></div> <script src="uslugi_map.js"></script><?php
		$query = "SELECT hospitals.id AS id, hospitals.name AS name, hospitals_nomenklatura.price AS price, hospitals_nomenklatura.oms AS oms, hospitals_nomenklatura.comments AS comments, hospitals_nomenklatura.hospitals_id AS h_id FROM hospitals, hospitals_nomenklatura WHERE hospitals.id=hospitals_nomenklatura.hospitals_id AND hospitals_nomenklatura.nomenklatura_id='$usluga'";
		echo '<br><table class="u-full-width">  <thead>
    <tr>
      <th>Наименование</th>
      <th>Стоимость</th>
      <th>ОМС</th>
    </tr>
  </thead>
  <tbody>';
		$sql_uchr = mysqli_query ($dbcnx, $query);
		while($uchrejd=mysqli_fetch_array($sql_uchr))
		{
			echo '<tr>';
			$link = '<a href="http://elop.ru?uchr='.$uchrejd[id].'">'.$uchrejd[name].'</a>';
			echo "<td>$link"; if ($uchrejd[comments]) echo "($uchrejd[comment])"; echo "</td>";
			echo "<td>$uchrejd[price] рублей</td><td>";
			if($uchrejd[oms]>0) echo "ОМС";
			echo '</td></tr>';
		}
	echo '  </tbody></table>';	
	}
	
} else
{
?>
	<script>
	$(document).ready(function () {
		$('#find').keyup(function () {
			var find = $(this).val();

			$('#uchrejd').html('загрузка...');
			
			var url = 'get_uchr.php';
			
			$.get(
				url,
				"find=" + find,
				function (result) {
					if (result.type == 'error') {
						alert('error');
						return(false);
					}
					else {
						var uchrejd = '';
						$(result.r_ar).each(function() {
							uchrejd += '<div class="search_card"><a href="./index.php?uchr=' + $(this).attr('id') + '">' + $(this).attr('name') + '</a><div class="search_card_address">' + $(this).attr('address') + '</div></div>';
						});
						$('#uchrejd').html(uchrejd);
						$('#uslugi').html('');
					}
				},
				"json"
			);
		});
	});

	</script>
	<script>
	$(document).ready(function () {
		$('#find2').keyup(function () {
			var find = $(this).val();

			$('#uslugi').html('загрузка...');
			
			var url = 'get_uslugi.php';
			
			$.get(
				url,
				"find=" + find,
				function (result) {
					if (result.type == 'error') {
						alert('error');
						return(false);
					}
					else {
						var uslugi = '';
						$(result.r_ar).each(function() {
							uslugi += '<div class="search_card">' + $(this).attr('kod') + '<a href="./index.php?usluga=' + $(this).attr('id') + '">' + $(this).attr('name') + '</a><br></div>';
						});
						$('#uslugi').html(uslugi);
						$('#uchrejd').html('');
					}
				},
				"json"
			);
		});
	});

	</script>

	<div class="switch">
		<div class="switch-element">
			<div class="switch-element__one active">Лечебное заведение</div>
			<div class="switch-element__two">Услуга</div>
		</div>
		<div class="switch-body">
			<div class="switch-element__one active">
				<input type="text" id="find" class="find" name="find" placeholder="Укажите лечебное заведение">
			</div>
			<div class="switch-element__two">
				<input type="text" id="find2" class="find2" name="find2" placeholder="Укажите услугу">
			</div>
		</div>
	</div>
	
		<div class="uchrejd" id= "uchrejd">
		<?php
			// $query = "SELECT * FROM hospitals ORDER BY full_name LIMIT 10";
			// $sql_uchr = mysqli_query ($dbcnx, $query);
			// while($uchr=mysqli_fetch_array($sql_uchr))
			// {
				// echo "<div class='search_card'><a href='./index.php?uchr=".$uchr[id]."'>",$uchr[full_name],"</a></div>";
				// //echo $uchr[name], "</br>";
			// }
		?>
		</div>
		<div class="uslugi" id= "uslugi"></div>
 <?php
}
 ?>