<?php

require_once __DIR__."/../vendor/autoload.php";

use AdamWojs\FilterBuilder\Parser\ArrayParser;

$parser = new ArrayParser();

//var_dump($parser->parse([
//    'foo' => [
//        '$eq' => 'bar'
//    ]
//]));
//
//die();

var_dump($parser->parse([
    '$and' => [
        [
            'foo' => [
                '$eq' => 'Foo'
            ]
        ],
        [
            'bar' => [
                '$lt' => 25
            ]
        ]
    ]
]));
