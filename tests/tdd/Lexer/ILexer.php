<?php

/*TDD*/

declare(strict_types=1);

require_once(__DIR__ . "/../../../vendor/autoload.php");

use PST\Testing\Exceptions\ShouldException;
use PST\Testing\Should;

use function PST\Debugging\dp;

try {
    Should::beAnInterface('PST\Lexical\Lexer\ILexer');

    Should::beA(
        'PST\Lexical\Lexer\ILexer',

        'ArrayAccess',
        'Countable',
        'SeekableIterator'
    );

    Should::haveMethod(
        'PST\Lexical\Lexer\ILexer',

        'read',
        'peek',
        'prev',
        'input',
        'inputPosition',
        'setInput',
        'parsers',
        'addParsers',
        'removeParsers',
        'tokens'

    );

} catch (ShouldException $e) {
    dp($e->getMessage());

} catch (\Throwable $e) {
    throw $e;
}