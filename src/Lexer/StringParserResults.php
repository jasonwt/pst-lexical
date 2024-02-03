<?php

declare(strict_types=1);

namespace PST\Lexical\Lexer;

/**
 * Class StringParserResults
 * 
 * @package PST\Lexical\Lexer
 * 
 */
class StringParserResults {
    private ILexerToken $token;
    private int $nextOffset;

    public function __construct(ILexerToken $token, int $nextOffset) {
        $this->token = $token;
        $this->nextOffset = $nextOffset;
    }

    /**
     * token
     * 
     * @return ILexerToken 
     * 
     */
    public function token(): ILexerToken {
        return $this->token;
    }

    /**
     * nextOffset
     * 
     * @return int 
     * 
     */
    public function nextOffset(): int {
        return $this->nextOffset;
    }
}