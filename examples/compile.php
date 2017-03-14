<?php

require_once __DIR__."/../vendor/autoload.php";

use AdamWojs\FilterBuilder\Compiler\Mongo\MongoCompilerBuilder;
use AdamWojs\FilterBuilder\Expression\Compare\Eq;
use AdamWojs\FilterBuilder\Expression\Compare\Lt;
use AdamWojs\FilterBuilder\Expression\Id;
use AdamWojs\FilterBuilder\Expression\Logical\LogicalAnd;
use AdamWojs\FilterBuilder\Expression\Value;

$expr = new LogicalAnd(
    new Eq(new Id("foo"), new Value("Foo")),
    new Lt(new Id("bar"), new Value("BAAAR"))
);

$builder = new MongoCompilerBuilder();
$compiler = $builder->build();
var_dump($compiler->compile($expr));


$json_expr = [
    '$and' => [
        '$eq' => [
            'id' => 'foo', 'value' => 'Foo'
        ],
        '$lt' => [
            'bar', 'BAAAR'
        ]
    ]
];
