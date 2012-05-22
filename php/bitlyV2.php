<?
// taken from http://davidwalsh.name/bitly-php


/* make a URL small */
function make_bitly_url($url,$login,$appkey,$format = 'xml',$version = '2.0.1')
{
    //create the URL
    $bitly = 'http://api.bit.ly/shorten?version='.$version.'&amp;longUrl='.urlencode($url).'&amp;login='.$login.'&amp;apiKey='.$appkey.'&amp;format='.$format;
    //get the url
    //could also use cURL here
    $response = file_get_contents($bitly);

    //parse depending on desired format
    if (strtolower($format) == 'json') {
        $json = @json_decode($response,true);
        return $json['results'][$url]['shortUrl'];
    } else {
        $xml = simplexml_load_string($response);
        return 'http://bit.ly/'.$xml-&gt;results-&gt;nodeKeyVal-&gt;hash;
    }
}

/* usage */
// $short = make_bitly_url('http://davidwalsh.name','davidwalshblog','R_96acc320c5c423e4f5192e006ff24980','json');
// echo 'The short URL is:  '.$short; 
// returns:  http://bit.ly/11Owun

?>
