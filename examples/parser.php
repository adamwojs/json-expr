<?php

require_once __DIR__ . "/../vendor/autoload.php";

use AdamWojs\FilterBuilder\Expression\Compare\Eq;
use AdamWojs\FilterBuilder\Expression\Compare\Gt;
use AdamWojs\FilterBuilder\Expression\Compare\Gte;
use AdamWojs\FilterBuilder\Expression\Compare\Lt;
use AdamWojs\FilterBuilder\Expression\Compare\Lte;
use AdamWojs\FilterBuilder\Expression\Logical\LogicalAnd;
use AdamWojs\FilterBuilder\Expression\Logical\LogicalNot;
use AdamWojs\FilterBuilder\Expression\Logical\LogicalOr;
use AdamWojs\FilterBuilder\Parser\CompareOperatorFactory;
use AdamWojs\FilterBuilder\Parser\LogicalOperatorFactory;
use AdamWojs\FilterBuilder\Parser\ParserException;
use AdamWojs\FilterBuilder\Parser\Parser;
use AdamWojs\FilterBuilder\Parser\SymbolTable\SymbolTable;

$compareOperatorFactory = new CompareOperatorFactory();
$compareOperatorFactory->register('$eq', Eq::class, true);
$compareOperatorFactory->register('$lt', Lt::class);
$compareOperatorFactory->register('$lte', Lte::class);
$compareOperatorFactory->register('$gt', Gt::class);
$compareOperatorFactory->register('$gte', Gte::class);

$logicalOperatorFactory = new LogicalOperatorFactory();
$logicalOperatorFactory->register('$and', LogicalAnd::class);
$logicalOperatorFactory->register('$or', LogicalOr::class);
$logicalOperatorFactory->register('$not', LogicalNot::class);

$symbolTable = new SymbolTable([
    'foo', 'bar'
]);

$parser = new Parser(
    $compareOperatorFactory,
    $logicalOperatorFactory,
    $symbolTable
);

try {
    $expr = $parser->parse([
        '$and' => [
            [
                'foo' => 'Foo'
            ],
            [
                'bar' => [
                    '$lt' => 25
                ]
            ]
        ]
    ]);

    var_dump($expr);
} catch (ParserException $ex) {
    // Re-throw exception
    throw $ex;
}
