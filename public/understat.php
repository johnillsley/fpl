<?php
header('content-type:text/html;charset=utf-8');

function get_string_between($string, $start, $end){
    $string = ' ' . $string;
    $ini = strpos($string, $start);
    if ($ini == 0) return '';
    $ini += strlen($start);
    $len = strpos($string, $end, $ini) - $ini;
    return substr($string, $ini, $len);
}

$page = file_get_contents('https://understat.com/league/EPL/2018');
$raw_data = get_string_between($page, "playersData	= JSON.parse('", "');");
$data = str_replace(
        array('\x5B', '\x7B', '\x22', '\x3A', '\x7D', '\x5D', '\x20', '\x2D', '\x5C', '\x26', '\x23', '\x3B'),
        array('[', '{', '"', ':', '}', ']', ' ', '-', '\\', '&', '#', ';'),
        $raw_data);
$data = preg_replace_callback('/\\\\u([0-9a-fA-F]{4})/', function ($match) {
    return mb_convert_encoding(pack('H*', $match[1]), 'UTF-8', 'UCS-2BE');
}, $data);

//print $data;
print "<pre>";
print_r(json_decode($data));
print "</pre>";
exit;