<?
/*
as http://bitly.com/a/your_api_key says:


bitly Username
sdbruder

bitly API Key
R_5257924e91d9cf6154f1dfa347433067


*/

/* returns the shortened url */
function get_bitly_short_url($url,$login='sdbruder',$appkey='R_5257924e91d9cf6154f1dfa347433067',$format='txt') {
        $connectURL = 'http://api.bit.ly/v3/shorten?login='.$login.'&amp;apiKey='.$appkey.'&amp;uri='.urlencode($url).'&amp;format='.$format;
        return curl_get_result($connectURL);
}

/* returns expanded url */
function get_bitly_long_url($url,$login='sdbruder',$appkey='R_5257924e91d9cf6154f1dfa347433067',$format='txt') {
        $connectURL = 'http://api.bit.ly/v3/expand?login='.$login.'&amp;apiKey='.$appkey.'&amp;shortUrl='.urlencode($url).'&amp;format='.$format;
        return curl_get_result($connectURL);
}

/* returns a result form url */
function curl_get_result($url) {
        $ch = curl_init();
        $timeout = 5;
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);
        $data = curl_exec($ch);
        curl_close($ch);
        return $data;
}

/* get the short url */
// $short_url = get_bitly_short_url('http://davidwalsh.name/','davidwalshblog','xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');

/* get the long url from the short one */
// $long_url = get_bitly_long_url($short_url,'davidwalshblog','xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx');


?>
