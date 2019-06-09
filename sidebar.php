<nav class="clearfix">
	<ul class="clearfix">
	<?php
		if ($razdel == NULL)
			echo "<li class='current'><a href='index.php' target='_self' title='Главная'>Главная</a></li>\n";
		else
			echo "<li><a href='index.php' target='_self' title='Главная'>Главная</a></li>\n";

	?>
<?php
$razdelname="Меню";
$query = "SELECT * FROM menu ORDER BY id";
$sql_razdely = mysqli_query ($dbcnx, $query);
while($razdely=mysqli_fetch_array($sql_razdely))
{
	if ($razdely[id]==$razdel)
	{
		$razdelname=$razdely['name'];
		echo "<li class='current'><a href='index.php?razdel=$razdely[id]' target='_self' title='$razdely[description]'>$razdely[name]</a></li>\n";
	}
	else
		echo "<li><a href='index.php?razdel=$razdely[id]' target='_self' title='$razdely[description]'>$razdely[name]</a></li>\n";
	}
?>
	</ul>
	<a href="#" id="pull"><?php echo "$razdelname";?></a>
</nav>
