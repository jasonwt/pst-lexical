<?php

declare(strict_types=1);

namespace PST\Lexical\Lexer;

use InvalidArgumentException;

/**
 * Class StringParser
 * 
 * @package PST\Lexical\Lexer
 * 
 */
abstract class StringParser implements IStringParser {
    private string $tokenType;

    protected function processMatches(array $matches) /*PHP8 :mixed*/ {
        return $matches;
    }

    /**
     * StringParser constructor.
     * 
     * @param string $tokenType 
     * 
     * @return void 
     * 
     * @throws InvalidArgumentException 
     * 
     */
    public function __construct(string $tokenType) {
        if (($this->tokenType = trim($tokenType)) === "")
            throw new InvalidArgumentException("Token type cannot be empty");
    }

    /**
     * Gets the token type
     * 
     * @return string 
     * 
     */
    public function tokenType(): string {
        return $this->tokenType;
    }
}