<?php

declare(strict_types=1);

namespace PST\Lexical\Parser;

use PST\Lexical\Lexer\ILexerToken;

interface ITokenParser {
    public function parse(ILexerToken $token): ?INode;
}