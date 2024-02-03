<?php

declare(strict_types=1);

namespace PST\Lexical\Lexer;

/**
 * Interface ILexerFactory
 * 
 * @package PST\Lexical\Lexer
 * 
 */
interface ILexerFactory {
    public function name(): string;
    public function parsers(): array;
    public function addTokenParsers(IStringParser ...$parsers): ILexerFactory;
    
    public static function new(string $name, IStringParser ...$parsers): ILexerFactory;
}