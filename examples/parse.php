<?php

require_once __DIR__ . "/../vendor/autoload.php";

use AdamWojs\FilterBuilder\Expression\Compare\Eq;
use AdamWojs\FilterBuilder\Expression\Compare\Gt;
use AdamWojs\FilterBuilder\Expression\Compare\Gte;
use AdamWojs\FilterBuilder\Expression\Compare\Lt;
use AdamWojs\FilterBuilder\Expression\Compare\Lte;
use AdamWojs\FilterBuilder\Expression\Logical\LogicalAnd;
use AdamWojs\FilterBuilder\Parser\CompareOperatorParser;
use AdamWojs\FilterBuilder\Parser\GenericParserBuilder;
use AdamWojs\FilterBuilder\Parser\LogicalOperatorParser;
use AdamWojs\FilterBuilder\Parser\ParserException;

$builder = new GenericParserBuilder();
$builder->addCompareOperator('$eq', new CompareOperatorParser(Eq::class));
$builder->addCompareOperator('$gt', new CompareOperatorParser(Gt::class));
$builder->addCompareOperator('$lt', new CompareOperatorParser(Lt::class));
$builder->addCompareOperator('$gte', new CompareOperatorParser(Gte::class));
$builder->addCompareOperator('$lte', new CompareOperatorParser(Lte::class));

$builder->addLogicalOperator('$or', new LogicalOperatorParser(LogicalAnd::class));
$builder->addLogicalOperator('$and', new LogicalOperatorParser(LogicalAnd::class));
$builder->addLogicalOperator('$not', new LogicalOperatorParser(LogicalAnd::class));

$parser = $builder->build();

try {
    $expr = $parser->parse([
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
    ]);

    var_dump($expr);
} catch (ParserException $ex) {
    // Re-throw exception
    throw $ex;
}
