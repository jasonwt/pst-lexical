<?php

declare(strict_types=1);

namespace PST\Lexical\Lexer;

/**
 * Interface IStringParser
 * 
 * @package PST\Lexical\Lexer
 * 
 */
interface IStringParser {
    public function parse(string $input, int $offset): ?StringParserResults;
    public function tokenType(): string;
}