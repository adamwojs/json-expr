Grammar recognized by parser
============================

    EXPR ::= LOGICAL_EXPR | COMPARE_EXPR
    LOGICAL_EXPR ::= LOGICAL_OPEATOR '{' EXPR+ '}'
    LOGICAL_OPEATOR ::= '$and'|'$or'|'$not'
    COMPARE_EXPR ::= COMPARE | COMPARE_EXPR_WITH_DEFAULT_OPERATOR
    COMPARE ::= ID '=>' '{' COMPARE_OPEATOR '=>' VALUE '}'
    COMPARE_EXPR_WITH_DEFAULT_OPERATOR ::= ID '=>' VALUE
    COMPARE_OPEATOR ::= '$eq'|'$gt'|'$lt'|'$gte'|'$lte'
    ID ::= {a-zA-Z_}{a-zA-Z0-9_}+
    VALUE ::= ...


