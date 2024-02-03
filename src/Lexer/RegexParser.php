<?php

declare(strict_types=1);

namespace PST\Lexical\Lexer;

use PST\Lexical\Patterns;

use InvalidArgumentException;

/**
 * Class RegexParser
 * 
 * @package PST\Lexical\Lexer
 * 
 */
class RegexParser extends StringParser {
    private string $regexDelimiter = "/";
    private PatternTermination $patternTermination;
    private string $pattern;

    /**
     * RegexParser constructor.
     * 
     * @param string $pattern 
     * @param string $tokenType 
     * @param null|PatternTermination $patternTermination 
     * @param string $regexDelimiter 
     * 
     * @return void 
     * 
     * @throws InvalidArgumentException 
     * 
     */
    public function __construct(string $pattern, string $tokenType, ?PatternTermination $patternTermination = null, string $regexDelimiter = "/") {
        $this->patternTermination = $patternTermination ?? PatternTermination::default();

        if (Patterns::validDelimiter($this->regexDelimiter = trim($regexDelimiter)) === false)
            throw new InvalidArgumentException("Invalid regex delimiter: '$regexDelimiter'");

        if (($this->pattern = trim($pattern)) === "")
            throw new InvalidArgumentException("Pattern cannot be empty");

        parent::__construct($tokenType);
    }

    /**
     * Gets the regex delimiter
     * 
     * @return string 
     * 
     */
    public function regexDelimiter(): string {
        return $this->regexDelimiter;
    }

    /**
     * Gets the pattern termination patter object
     * 
     * @return PatternTermination 
     * 
     */
    public function termination(): PatternTermination {
        return $this->patternTermination;
    }

    /**
     * Gets the pattern
     * 
     * @return string 
     * 
     */
    public function pattern(): string {
        return $this->pattern;
    }

    /**
     * Parses the input string
     * 
     * @param string $input 
     * @param int $offset 
     * 
     * @return null|StringParserResults 
     * 
     * @throws InvalidArgumentException 
     * 
     */
    public function parse(string $input, int $offset): ?StringParserResults {
        if ($offset < 0 || $offset >= strlen($input))
            throw new InvalidArgumentException("Invalid offset: $offset");

        $pattern = $this->pattern . $this->patternTermination->termination();
        $pattern = $this->regexDelimiter . '^(' . $pattern . ')' . $this->regexDelimiter;

//        echo "pattern: $pattern\n";

        if (preg_match($pattern, substr($input, $offset), $matches)) {
            if (($arrayKeyLast = array_key_last($matches)) === null)
                throw new InvalidArgumentException("Invalid matches: " . print_r($matches, true));

            $completeMatch = array_shift($matches);
            $terminatorMatch = array_pop($matches);

            $newOffset = $offset + strlen($completeMatch) - strlen($terminatorMatch);

            if ($newOffset === $offset)
                throw new InvalidArgumentException("newOffset === offset: " . print_r($matches, true));

            $matches = $this->processMatches($matches);

            return new StringParserResults(new LexerToken($matches, $this->tokenType()), $newOffset);
        }

        return null;
    }

    /************************************* FACTORY METHODS *************************************/

    /**
     * Creates a new instance of RegexParser
     * 
     * @param string $pattern 
     * @param string $tokenType 
     * @param null|PatternTermination $patternTermination 
     * @param string $regexDelimiter 
     * 
     * @return RegexParser 
     * 
     */
    public static function new (string $pattern, string $tokenType, ?PatternTermination $patternTermination = null, string $regexDelimiter = "/"): RegexParser {
        return new static($pattern, $tokenType, $patternTermination, $regexDelimiter);
    }
}