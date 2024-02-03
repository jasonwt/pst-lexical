<?php

declare(strict_types=1);

namespace PST\Lexical\Lexer;

/**
 * Interface ILexerToken
 * 
 * @package PST\Lexical\Lexer
 * 
 */
interface ILexerToken {
    public function value()/*PHP8: mixed*/;
    public function type(): string;
}