<?php

// $obj = new stdClass();

// // We cannot use an object as a key here
// // [
// //     $obj => 'foobar'
// // ];

// // In the past
// $store = new SplObjectStorage();
// $store[$obj] = 'foobar';

// var_dump($store[$obj]);

// // This approach restrict garbage collection
// unset($obj);

// var_dump($store); // Still exists
// var_dump($store->current());

// WeakMap solve this problem

$obj = new stdClass();

$store = new WeakMap();

$store[$obj] = 'foobar';

var_dump($store);

unset($obj);

var_dump($store);
