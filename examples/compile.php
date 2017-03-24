<?php

require_once __DIR__."/../vendor/autoload.php";

use AdamWojs\JsonExpr\Compiler\Mongo\MongoCompilerBuilder;
use AdamWojs\JsonExpr\Expression\Compare\Eq;
use AdamWojs\JsonExpr\Expression\Compare\Lt;
use AdamWojs\JsonExpr\Expression\Id;
use AdamWojs\JsonExpr\Expression\Logical\LogicalAnd;
use AdamWojs\JsonExpr\Expression\Value;

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
