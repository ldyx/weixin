<?php
$url = "http://52ssr.net";
$curl = curl_init(); 
curl_setopt($curl, CURLOPT_URL, $url);  
curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);  
curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);  
curl_setopt($curl,CURLOPT_USERAGENT,"Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; SV1; .NET CLR 1.1.4322; .NET CLR 2.0.50727)"); 
$contents = curl_exec($curl);
curl_close($curl);

$tag = "a";
$attr = "class";
$value = "btn btn-info btn-block";
$regex = "/<$tag.*?$attr=\".*?$value.*?\".*?href=\"(.*?)>(.*?)<\/$tag>/is";
preg_match_all($regex,$contents,$matches,PREG_PATTERN_ORDER);
echo $matcher;
?>
