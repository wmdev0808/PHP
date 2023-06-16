<?php

# str_starts_with

$id1 = 'inv_adsfadsfadsdsa';
// $result1 = stripos($id, 'inv_') === 0;
$result1 = str_starts_with($id1, 'inv_');

var_dump($result1);

# str_ends_with
$id2 = 'adsfafeafafaafe_ch';
// $result2 = stripos(strrev($id), strrev('_ch')) === 0;
// var_dump(preg_match('/_ch$/', $id2));
$result2 = str_ends_with($id2, '_ch');

var_dump($result2);

# str_contains
$url = 'https://example.com?foo=bar';

// var_dump(parse_url($url)['query']);

// $result3 = strpos($url, '?') !== false;
$result3 = str_contains($url, '?');
var_dump($result3);
