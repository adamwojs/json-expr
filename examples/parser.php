<?php

require_once __DIR__ . "/../vendor/autoload.php";

use AdamWojs\JsonExpr\Expression\Compare\Eq;
use AdamWojs\JsonExpr\Expression\Compare\Gt;
use AdamWojs\JsonExpr\Expression\Compare\Gte;
use AdamWojs\JsonExpr\Expression\Compare\Lt;
use AdamWojs\JsonExpr\Expression\Compare\Lte;
use AdamWojs\JsonExpr\Expression\Logical\LogicalAnd;
use AdamWojs\JsonExpr\Expression\Logical\LogicalNot;
use AdamWojs\JsonExpr\Expression\Logical\LogicalOr;
use AdamWojs\JsonExpr\Parser\OperatorProvider\CompareOperatorProvider;
use AdamWojs\JsonExpr\Parser\OperatorProvider\LogicalOperatorProvider;
use AdamWojs\JsonExpr\Parser\Exception\ParserException;
use AdamWojs\JsonExpr\Parser\Parser;
use AdamWojs\JsonExpr\Parser\SymbolTable\SymbolTable;

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
