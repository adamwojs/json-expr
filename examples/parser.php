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
use AdamWojs\FilterBuilder\Parser\OperatorProvider\CompareOperatorProvider;
use AdamWojs\FilterBuilder\Parser\OperatorProvider\LogicalOperatorProvider;
use AdamWojs\FilterBuilder\Parser\Exception\ParserException;
use AdamWojs\FilterBuilder\Parser\Parser;
use AdamWojs\FilterBuilder\Parser\SymbolTable\SymbolTable;

$compareOperatorProvider = new CompareOperatorProvider();
$compareOperatorProvider->register('$eq', Eq::class, true);
$compareOperatorProvider->register('$lt', Lt::class);
$compareOperatorProvider->register('$lte', Lte::class);
$compareOperatorProvider->register('$gt', Gt::class);
$compareOperatorProvider->register('$gte', Gte::class);

$logicalOperatorProvider = new LogicalOperatorProvider();
$logicalOperatorProvider->register('$and', LogicalAnd::class);
$logicalOperatorProvider->register('$or', LogicalOr::class);
$logicalOperatorProvider->register('$not', LogicalNot::class);

$symbolTable = new SymbolTable([
    'foo', 'bar'
]);

$parser = new Parser(
    $compareOperatorProvider,
    $logicalOperatorProvider,
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
