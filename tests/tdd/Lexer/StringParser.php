<?php

/*TDD*/

declare(strict_types=1);

require_once(__DIR__ . "/../../../vendor/autoload.php");

use PST\Testing\Exceptions\ShouldException;
use PST\Testing\Should;

use function PST\Debugging\dp;

try {
    Should::beAClass('PST\Lexical\Lexer\StringParser');
    Should::beA(
        'PST\Lexical\Lexer\StringParser',
        'PST\Lexical\Lexer\IStringParser'
    );
    Should::haveMethod(
        'PST\Lexical\Lexer\StringParser',

        'processMatches',
    );

} catch (ShouldException $e) {
    dp($e->getMessage());

} catch (\Throwable $e) {
    throw $e;
}