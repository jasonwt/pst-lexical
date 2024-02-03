<?php

declare(strict_types=1);

namespace PST\Lexical\Lexer;

use ArrayAccess;
use Countable;
use SeekableIterator;

/**
 * Interface ILexer
 * 
 * @package PST\Lexical\Lexer
 * 
 */
interface ILexer extends ArrayAccess, Countable, SeekableIterator {
    public function read(): ?ILexerToken;
    public function peek(): ?ILexerToken;
    public function prev(): ?ILexerToken;
    public function input(): string;
    public function inputPosition(): int;
    public function setInput(string $input, bool $ignoreWhiteSpaces = true): void;
    public function parsers(): array;
    public function addParsers(IStringParser ...$parsers): void;
    public function removeParsers(IStringParser ...$parsers): void;
    public function tokens(): array;
}