<?
	include('bitlyV3.php');
	$url = $_GET['addr'];	
	echo get_bitly_short_url($url);
?>