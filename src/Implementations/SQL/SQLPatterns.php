<?php

declare(strict_types=1);

namespace PST\Lexical\Implementations\SQL;

use PST\Lexical\Patterns;

/**
 * Class SQLPatterns
 * 
 * @package PST\Lexical\Implementations\SQL
 * 
 */
class SQLPatterns extends Patterns {
    const COLUMN_IDENTIFIER = '?:([a-zA-Z_][a-zA-Z0-9_]*)(?:\.([a-zA-Z_][a-zA-Z0-9_]*))?(?:\.([a-zA-Z_][a-zA-Z0-9_]*))?';
    
    const ALIAS_IDENTIFIER = '(?:as)\s+([a-zA-Z_][a-zA-Z0-9_]*)';
    const BEGIN_QUERY_TERMS = '(SELECT|UPDATE|DELETE\s*FROM|INSERT\s*INTO)';
}