<?php

/*TDD*/

declare(strict_types=1);

require_once(__DIR__ . "/../../../vendor/autoload.php");

use PST\Testing\Exceptions\ShouldException;
use PST\Testing\Should;

use function PST\Debugging\dp;

try {
    Should::beAClass('PST\Lexical\Lexer\Lexer');

    Should::beA(
        'PST\Lexical\Lexer\Lexer',

        'PST\Lexical\Lexer\ILexer'
    );

} catch (ShouldException $e) {
    dp($e->getMessage());

} catch (\Throwable $e) {
    throw $e;
}