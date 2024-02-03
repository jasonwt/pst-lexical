<?php

declare(strict_types=1);

namespace PST\Lexical\Implementations\SQL;

use PST\Lexical\Lexer\LexerFactory;
use PST\Lexical\Lexer\PatternTermination;
use PST\Lexical\Lexer\RegexParser;
use PST\Lexical\Patterns;

/**
 * Class SQLLexerFactory
 * 
 * @package PST\Lexical\Implementations\SQL
 * 
 */
class SQLLexerFactory extends LexerFactory {}

SQLLexerFactory::addFactories(
    SQLLexerFactory::new('SELECT_EXPRESSION')
        ->addTokenParsers(
            RegexParser::new('[,]', 'COMMA'),
            RegexParser::new(SQLPatterns::ALIAS_IDENTIFIER, 'ALIAS', PatternTermination::new([',', '\s', '$'])),
            RegexParser::new(SQLPatterns::COLUMN_IDENTIFIER, 'COLUMN_IDENTIFIER', PatternTermination::new([',', '\s', '$'])),
            RegexParser::new(Patterns::QUOTED, 'QUOTED', PatternTermination::new([',', '\s', '$', '.'])),
            RegexParser::new('.*', 'REMAINING')
        )
);