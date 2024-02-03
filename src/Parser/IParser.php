<?php

declare(strict_types=1);

namespace PST\Lexical\Parser;

use PST\Lexical\Lexer\ILexer;

interface IParser {
    public function parse(ILexer $lexer): ?INode;
}