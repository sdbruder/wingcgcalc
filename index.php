<?php
$locale = explode(',',$_SERVER['HTTP_ACCEPT_LANGUAGE']);
if (strpos($locale[0], '_') !== false) {
	$tk = explode('_',$locale[0]);
} elseif (strpos($locale[0], '-') !== false) {
	$tk = explode('-',$locale[0]);
}
if ($tk[0] == "pt") {
	header('Location: pt_BR/');
} else {
	header('Location: en_US/');
}
?>
