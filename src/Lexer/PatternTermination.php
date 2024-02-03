<?php

declare(strict_types=1);

namespace PST\Lexical\Lexer;

use PST\Lexical\Patterns;

use InvalidArgumentException;

/**
 * Class PatternTermination
 * 
 * @package PST\Lexical\Lexer
 * 
 */
class PatternTermination{
    private array $terminators = [];
    private string $regexDelimiter;

    /**
     * PatternTermination constructor
     * 
     * @param string $terminator 
     * @param string $regexDelimiter 
     * 
     * @return void 
     * 
     * @throws InvalidArgumentException 
     * 
     */
    public function __construct(string $terminator, string $regexDelimiter = "/") {
        if (Patterns::validDelimiter($this->regexDelimiter = trim($regexDelimiter)) === false)
            throw new InvalidArgumentException("Invalid regex delimiter: '$regexDelimiter'");

        if (($terminator = trim($terminator)) !== "")
            $this->terminators[] = $terminator;
    }

    /**
     * regexDelimiter
     * 
     * @return string 
     * 
     */
    public function regexDelimiter(): string {
        return $this->regexDelimiter;
    }

    /**
     * termination
     * 
     * @return string 
     * 
     */
    public function termination(): string {
        return "(" . implode("|", $this->terminators) . ")";
    }

    /**
     * or
     * 
     * @param string ...$terminators 
     * 
     * @return PatternTermination 
     * 
     * @throws InvalidArgumentException 
     * 
     */
    public function or (string ...$terminators): PatternTermination {
        $newTermination = new static("", $this->regexDelimiter);

        $newTermination->terminators = array_map(function($t): string {
            if (($t = trim($t)) === "")
                throw new InvalidArgumentException("Terminator cannot be empty");

            return $t;
        }, array_unique(array_merge($terminators, $this->terminators)));

        return $newTermination;
    }
    
    /************************************* FACTORY METHODS *************************************/

    /**
     * Creates a new instance of PatternTermination
     * 
     * @param string|array $terminators 
     * @param string $regexDelimiter 
     * 
     * @return PatternTermination 
     * 
     * @throws InvalidArgumentException 
     * 
     */
    public static function new(/*PHP8 string|array*/ $terminators, string $regexDelimiter = "/"): PatternTermination {
        if (is_string($terminators))
            $terminators = [$terminators];
        

        $newTermination = new static("", $regexDelimiter);

        foreach ($terminators as $terminator) {
            if (!is_string($terminator))
                throw new InvalidArgumentException("Terminator must be a string or array");

            if (($terminator = trim($terminator)) === "")
                throw new InvalidArgumentException("Terminator cannot be empty");

            $newTermination = $newTermination->or($terminator);
        }

        return $newTermination;
    }

    /**
     * Creates a new instance of PatternTermination with no terminators
     * 
     * @param string $regexDelimiter 
     * 
     * @return PatternTermination 
     * 
     */
    public static function default(string $regexDelimiter = "/"): PatternTermination {
        return new static("", $regexDelimiter);
    }
}