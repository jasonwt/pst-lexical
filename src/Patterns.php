<?php

declare(strict_types=1);

namespace PST\Lexical;

/**
 * Class Patterns
 * 
 * @package PST\Lexical
 * 
 */
class Patterns {
    const ANYSINGLE = '.';
    const EVERYTHING = '.*';
    const WHITESPACE = '\s';
    const NON_WHITESPACE = '\S';
    const WORD = '\w+';
    const NUMERIC = '[+-]?\d+(\.\d+)?';
    const DECIMAL = '[+-]?\d+(\.\d+)';
    const INTEGER = '[+-]?\d+';
    const QUOTED = '(?:["\'`])(?:.*?)(?<!\\\\)[`\'"]';

    public static function validDelimiter(string $delimiter): bool {
        if (($delimiter = trim($delimiter)) === "")
            return false;
        
        return in_array($delimiter, ['/', '#', '~', '@', '!', '%', '^', '&', '*', '+', '-', '=', '?', ':', ';', '|', /*'\\',*/ '.']);
    }
}