<?php

/*TDD*/

declare(strict_types=1);

require_once(__DIR__ . "/../../../vendor/autoload.php");

use PST\Testing\Exceptions\ShouldException;
use PST\Testing\Should;

use function PST\Debugging\dp;

try {
    Should::beAClass('PST\Lexical\Lexer\LexerFactory');

    Should::beA(
        'PST\Lexical\Lexer\LexerFactory',

        'PST\Lexical\Lexer\ILexerFactory'
    );

    Should::haveMethod(
        'PST\Lexical\Lexer\LexerFactory',

        'name',
        'parsers',
        'addTokenParsers',
        'new',
        'addFactories',
        'factories',
        'instantiate',
        'removeFactories'
    );

} catch (ShouldException $e) {
    dp($e->getMessage());

} catch (\Throwable $e) {
    throw $e;
}