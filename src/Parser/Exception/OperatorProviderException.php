<?php

namespace AdamWojs\JsonExpr\Parser\Exception;

class OperatorProviderException extends ParserException
{
    /**
     * OperatorProviderException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct($message = "", $code = 0, \Exception $previous = null)
    {
        parent::__construct($message, $code, $previous);
    }
}
