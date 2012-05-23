<?

	include('bitlyV3.php');
	$url = $_GET['addr'];
	syslog(LOG_WARNING, "short.php URL = $url");
	
	//echo $url . "</br>\n";	
	echo get_bitly_short_url($url);

?>