<?php

namespace AdamWojs\FilterBuilder\Parser\Exception;

/**
 * Base parser exception.
 *
 * @author Adam Wójs <adam@wojs.pl>
 */
class ParserException extends \Exception
{
    /**
     * ParserException constructor.
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
