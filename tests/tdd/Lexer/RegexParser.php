<?php

/*TDD*/

declare(strict_types=1);

require_once(__DIR__ . "/../../../vendor/autoload.php");

use PST\Testing\Exceptions\ShouldException;
use PST\Lexer\Lexer\RegexParser;
use PST\Testing\Should;

use function PST\Debugging\dp;

try {
    Should::beAClass('PST\Lexical\Lexer\RegexParser');

    Should::beA(
        'PST\Lexical\Lexer\RegexParser',
        'PST\Lexical\Lexer\StringParser'
    );

    Should::haveMethod(
        'PST\Lexical\Lexer\RegexParser',

        'regexDelimiter',
        'termination',
        'pattern',
        'tokenType',
        'processMatches',
        'parse',

        'new',
        
    );

} catch (ShouldException $e) {
    dp($e->getMessage());

} catch (\Throwable $e) {
    throw $e;
}