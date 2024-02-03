<?php

declare(strict_types=1);

namespace PST\Lexical\Lexer;

use InvalidArgumentException;

/**
 * Lexer
 * 
 * @package PST\Lexer\Lexer
 * 
 */
class Lexer implements ILexer {
    private int $tokensIndex = 0;
    private string $input = "";
    private int $inputLength = 0;
    private int $inputPosition = 0;
    private array $parsers = [];
    private array $tokens = [];

    public function __construct(string $input, IStringParser ... $parsers) {
        $this->addParsers(... $parsers);

        $this->setInput($input);
    }

    /**
     * Gets the current token
     * 
     * @return ILexerToken 
     * 
     */
    public function current(): ILexerToken {
        return $this->tokens[$this->tokensIndex];
    }

    /**
     * Moves to the next token
     * 
     * @return void 
     * 
     */
    public function next(): void {
        $this->tokensIndex++;
    }

    /**
     * Gets the current token index
     * 
     * @return int 
     * 
     */
    public function key(): int {
        return $this->tokensIndex;
    }

    /**
     * Checks if the current token is valid
     * 
     * @return bool 
     * 
     */
    public function valid(): bool {
        return isset($this->tokens[$this->tokensIndex]);
    }

    /**
     * Rewinds the tokens to the first token
     * 
     * @return void 
     * 
     */
    public function rewind(): void {
        $this->tokensIndex = 0;
    }

    /**
     * Seeks to a position.  
     * If $seekSet is true, the position is absolute, otherwise it is relative to the current position
     * 
     * @param int $position 
     * @param bool $seekSet 
     * 
     * @return void 
     * 
     * @throws InvalidArgumentException 
     * 
     */
    public function seek(int $position, bool $seekSet = true): void {
        if (!$seekSet)
            $position += $this->tokensIndex;

        if (!isset($this->tokens[$position]))
            throw new InvalidArgumentException("Invalid seek position");
        
        $this->tokensIndex = $position;
    }

    /**
     * Checks if an offset exists
     * 
     * @param mixed $offset 
     * 
     * @return bool 
     * 
     */
    public function offsetExists($offset): bool {
        return isset($this->tokens[$offset]);
    }

    /**
     * Gets a token at an offset
     * 
     * @param mixed $offset 
     * 
     * @return object 
     * 
     * @throws InvalidArgumentException 
     * 
     */
    public function offsetGet($offset): object {
        if ($offset < 0)
            $offset += $this->tokensIndex;

        if ($offset < 0 || $offset >= count($this->tokens))
            throw new InvalidArgumentException("Invalid offset: $offset");

        return $this->tokens[$offset];
    }

    /**
     * This operation is not allowed. 
     * Required to implement the method because it is part of the ArrayAccess interface
     * 
     * @param mixed $offset 
     * @param mixed $value 
     * 
     * @return void 
     * 
     * @throws InvalidArgumentException 
     * 
     */
    public function offsetSet($offset, $value): void {
        throw new InvalidArgumentException("Cannot set tokens");
    }

    /**
     * This operation is not allowed.  
     * Required to implement the method because it is part of the ArrayAccess interface
     * 
     * @param mixed $offset 
     * 
     * @return void 
     * 
     * @throws InvalidArgumentException 
     * 
     */
    public function offsetUnset($offset): void {
        throw new InvalidArgumentException("Cannot unset tokens");
    }

    /**
     * Counts the number of tokens
     * 
     * @return int 
     * 
     */
    public function count(): int {
        return count($this->tokens);
    }

    /**
     * Reads the curren token and moves to the next token
     * 
     * @return ILexerToken 
     * 
     */
    public function read(): ?ILexerToken {
        if (($token = $this->tokens[$this->tokensIndex] ?? null) !== null)
            $this->tokensIndex++;

        return $token;
    }

    /**
     * Peeks at the next token
     * 
     * @return ILexerToken 
     * 
     */
    public function peek(): ?ILexerToken {
        return $this->tokens[$this->tokensIndex+1] ?? null;
    }

    /**
     * Peeks at the previous token
     * 
     * @return ILexerToken 
     * 
     */
    public function prev(): ?ILexerToken {
        return $this->tokens[$this->tokensIndex-1] ?? null;
    }

    /**
     * Gets the input string
     * 
     * @return string 
     * 
     */
    public function input(): string {
        return $this->input;
    }

    /**
     * Gets the current input position
     * 
     * @return int 
     * 
     */
    public function inputPosition(): int {
        return $this->inputPosition;
    }

    /**
     * Sets the input string
     * if $ignoreWhiteSpaces is true, white spaces are ignored and not tokenized
     * 
     * @param string $input 
     * @param bool $ignoreWhiteSpaces 
     * 
     * @return void 
     * 
     */
    public function setInput(string $input, bool $ignoreWhiteSpaces = true): void {
        $this->input = $input;
        $this->tokens = [];
        $this->inputLength = strlen($input);
        $this->inputPosition = 0;

        while ($this->inputPosition < $this->inputLength) {
            if ($ignoreWhiteSpaces) {
                if (preg_match("/^\s+/", substr($input, $this->inputPosition), $matches)) {
                    $this->inputPosition += strlen($matches[0]);
                    continue;
                }
            }

            foreach ($this->parsers as $parser) {
                if (($token = $parser->parse($this->input, $this->inputPosition)) !== null) {
                    $this->inputPosition = $token->nextOffset();
                    $this->tokens[] = $token->token();

                    continue 2;
                }
            }

            break;
        }
    }

    /**
     * Gets the parsers
     * 
     * @return array 
     * 
     */
    public function parsers(): array {
        return $this->parsers;
    }

    /**
     * Adds parsers
     * 
     * @param IStringParser ...$parsers 
     * 
     * @return void 
     * 
     * @throws InvalidArgumentException 
     * 
     */
    public function addParsers(IStringParser ...$parsers): void {
        foreach ($parsers as $parser) {
            if (in_array($parser, $this->parsers, true))
                throw new InvalidArgumentException("Parser already added '{$parser->tokenType()}'");
            
            $this->parsers[] = $parser;
        }

        $this->setInput($this->input);
    }

    /**
     * Removes parsers
     * 
     * @param IStringParser ...$parsers 
     * 
     * @return void 
     * 
     * @throws InvalidArgumentException 
     * 
     */
    public function removeParsers(IStringParser ...$parsers): void {
        foreach ($parsers as $parser) {
            if (false !== ($index = array_search($parser, $this->parsers, true))) {
                unset($this->parsers[$index]);
            } else {
                throw new InvalidArgumentException("Parser not found '{$parser->tokenType()}'");
            }
        }
    }

    /**
     * Gets the tokens
     * 
     * @return array 
     * 
     */
    public function tokens(): array {
        return $this->tokens;
    }
}