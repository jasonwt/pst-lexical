<?php

/*TDD*/

declare(strict_types=1);

require_once(__DIR__ . "/../../../../vendor/autoload.php");

use PST\Testing\Exceptions\ShouldException;
use PST\Testing\Should;

use function PST\Debugging\dp;

try {
    Should::beAClass('PST\Lexical\Implementations\SQL\SQLLexerFactory');

    Should::beA(
        'PST\Lexical\Implementations\SQL\SQLLexerFactory',

        'PST\Lexical\Lexer\LexerFactory'
    );
    
} catch (ShouldException $e) {
    dp($e->getMessage());

} catch (\Throwable $e) {
    throw $e;
}