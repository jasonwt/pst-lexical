<?php

/*TDD*/

declare(strict_types=1);

require_once(__DIR__ . "/../../../vendor/autoload.php");

use PST\Testing\Exceptions\ShouldException;
use PST\Testing\Should;

use function PST\Debugging\dp;

try {
    Should::beAnInterface('PST\Lexical\Lexer\ILexerFactory');

    Should::haveMethod(
        'PST\Lexical\Lexer\ILexerFactory',

        'name',
        'parsers',
        'addTokenParsers',
        'new',
    );

} catch (ShouldException $e) {
    dp($e->getMessage());

} catch (\Throwable $e) {
    throw $e;
}