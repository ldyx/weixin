<?php
$key = 'dd9ea2173ef44d29b1ad729346639c46';
$re = json_decode(file_get_contents('http://www.tuling123.com/openapi/api?key='.$key.'&info='.$content.'&useid='.$fromUsername),true);
$content = $re['text'];
echo $content;
?>