<?php
$locale = "en_US";
if (isSet($_GET["locale"])) $locale = $_GET["locale"];
$tk = explode("/", $_SERVER["REQUEST_URI"]);
if ($tk[1]) $locale = $tk[count($tk)-2];
unset($tk[count($tk)-1]); // take the file out
unset($tk[count($tk)-1]); // take the last directory out


if (strpos($_SERVER["REQUEST_URI"],'i18n')) {
	print $_SERVER["REQUEST_URI"]."</br>\n";
	print $_SERVER["DOCUMENT_ROOT"]."</br>\n";
	print $locale."</br>\n";
	print count($tk)."</br>\n";
	print $_SERVER['DOCUMENT_ROOT'] .'/'. implode('/',$tk) . '/translations';
}
putenv("LC_ALL=$locale");
setlocale(LC_ALL, $locale);
bindtextdomain("wingcgcalc", $_SERVER['DOCUMENT_ROOT'] .'/'. implode('/',$tk) . '/translations');
bind_textdomain_codeset("wingcgcalc", 'UTF-8'); 
textdomain("wingcgcalc");
?>
