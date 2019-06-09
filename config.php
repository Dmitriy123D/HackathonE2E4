<?php
$dblacation = "localhost";
$dbname = "proba_zs";
$dbuser = "zsv";
$dbpasswd = "1pnn4SjcfcqTSAR";
$dbcnx =@mysqli_connect($dblacation, $dbuser, $dbpasswd, $dbname);
if (!$dbcnx) {exit ("<p>Сервер БД не доступен</p>");}
@mysqli_query($dbcnx, "SET NAMES 'utf8'");

date_default_timezone_set('Europe/Moscow');