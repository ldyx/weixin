<?php
$key = 'dd9ea2173ef44d29b1ad729346639c46';
$re = json_decode(file_get_contents('http://www.tuling123.com/openapi/api?key='.$key.'&info=看新闻'),true);
$list = $re['list'];
var_dump($list);
