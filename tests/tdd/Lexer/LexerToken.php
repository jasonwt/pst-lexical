<?php

/*TDD*/

declare(strict_types=1);

require_once(__DIR__ . "/../../../vendor/autoload.php");

use PST\Testing\Exceptions\ShouldException;
use PST\Lexical\Lexer\LexerToken;
use PST\Testing\Should;

use function PST\Debugging\dp;

try {
    Should::beAClass('PST\Lexical\Lexer\LexerToken');
    Should::beA(
        'PST\Lexical\Lexer\LexerToken',
        'PST\Lexical\Lexer\ILexerToken'
    );

    $token = new LexerToken("value", "type");

    Should::equal($token->value(), "value");
    Should::equal($token->type(), "type");

} catch (ShouldException $e) {
    dp($e->getMessage());

} catch (\Throwable $e) {
    throw $e;
}