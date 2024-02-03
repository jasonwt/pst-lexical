<?php

declare(strict_types=1);

namespace PST\Lexical\Lexer;

/**
 * Class LexerToken
 * 
 * @package PST\Lexical\Lexer
 * 
 */
class LexerToken implements ILexerToken {
    private /*PHP8 mixed*/ $value;
    private string $type;

    /**
     * LexerToken constructor.
     * 
     * @param mixed $value 
     * @param string $type 
     * 
     * @return void 
     * 
     */
    public function __construct(/*PHP8 mixed*/ $value, string $type) {
        $this->value = $value;
        $this->type = $type;
    }

    /**
     * Gets the token value
     * 
     * @return mixed 
     * 
     */
    public function value()/*PHP8: mixed*/ {
        return $this->value;
    }

    /**
     * Gets the token type
     * 
     * @return string 
     * 
     */
    public function type(): string {
        return $this->type;
    }
}