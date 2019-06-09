<?php 

require "lessc.inc.php";
$less = new lessc;
$less->checkedCompile("theme.less", "theme.css");

ob_start ("ob_gzhandler");
ob_start("compress");
header("Content-type:text/css; charset=UTF-8");
header("Cache-Control:must-revalidate");
$offset = 60 * 60 ;
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s",time() + $offset) . " GMT";
header($ExpStr);
function compress($buffer) {
	$buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);       
	$buffer = str_replace(array("\r\n","\r","\n","\t",'  ','    ','    '),'',$buffer);     
	$buffer = str_replace('{ ', '{', $buffer);
	$buffer = str_replace(' }', '}', $buffer);
	$buffer = str_replace('; ', ';', $buffer);
	$buffer = str_replace(', ', ',', $buffer);
	$buffer = str_replace(' {', '{', $buffer);
	$buffer = str_replace('} ', '}', $buffer);
	$buffer = str_replace(': ', ':', $buffer);
	$buffer = str_replace(' ,', ',', $buffer);
	$buffer = str_replace(' ;', ';', $buffer);
	$buffer = str_replace(';}', '}', $buffer);
	return $buffer;
}
 
require('imports.css');
require('normalize.css');
require('theme.css');
?>
