<?php

declare(strict_types=1);

namespace PST\Lexical\Lexer;

use InvalidArgumentException;

class LexerFactory implements ILexerFactory {
    private static array $factories = [];

    private string $name = "";
    private array $parsers = [];

    /**
     * Constructs a new instance of LexerFactory
     * 
     * @param string $name 
     * @param IStringParser[] $parsers 
     * 
     * @return void 
     * 
     */
    public function __construct(string $name, IStringParser ...$parsers) {
        $this->name = $name;

        $this->addTokenParsers(...$parsers);
    }

    /**
     * Gets the name of the factory
     * 
     * @return string 
     * 
     */
    public function name(): string {
        return $this->name;
    }

    /**
     * Gets the list of parsers
     * 
     * @return array 
     * 
     */
    public function parsers(): array {
        return $this->parsers;
    }

    /**
     * Adds token parsers
     * 
     * @param IStringParser[] $parsers
     * 
     * @return ILexerFactory 
     * 
     */
    public function addTokenParsers(IStringParser ...$parsers): ILexerFactory {
        $this->parsers = array_reduce($parsers, function (array $acc, IStringParser $parser): array {
            if (in_array($parser, $acc, true))
                return $acc;

            return array_merge($acc, [$parser]);
        }, $this->parsers);

        return $this;
    }
    
    /**
     * Creates a new instance of LexerFactory
     * 
     * @param string $name 
     * @param IStringParser[] $parsers 
     * 
     * @return ILexerFactory 
     * 
     */
    public static function new(string $name, IStringParser ...$parsers): ILexerFactory {
        return new static($name, ...$parsers);
    }

    /**
     * Adds new factories to the available factories
     * 
     * @param ILexerFactory[] $factories 
     * 
     * @return void 
     * 
     */
    public static function addFactories(ILexerFactory ...$factories): void {
        static::$factories = array_reduce($factories, function (array $acc, ILexerFactory $factory): array {
            if (isset($acc[$factory->name()]))
                return $acc;

            return array_merge($acc, [$factory->name() => $factory]);
        }, static::$factories);
    }

    /**
     * Gets the list of available factories
     * 
     * @return ILexerFactory[] 
     * 
     */
    public static function factories(): array {
        return static::$factories;
    }

    /**
     * Instantiates a new lexer from a factory
     * 
     * @param string $factoryName 
     * @param string $input 
     * @param bool $ignoreWhiteSpaces 
     * 
     * @return ILexer 
     * 
     * @throws InvalidArgumentException 
     * 
     */
    public static function instantiate(string $factoryName, string $input = "", bool $ignoreWhiteSpaces = true): ILexer {
        if (($factoryName = trim($factoryName)) === '')
            throw new InvalidArgumentException('Lexer Factory name cannot be empty');

        if (isset(static::$factories[$factoryName]) === false)
            throw new InvalidArgumentException("Lexer Factory '$factoryName' does not exist");

        $lexer = new Lexer("", ...static::$factories[$factoryName]->parsers());
        $lexer->setInput($input, $ignoreWhiteSpaces);

        return $lexer;
    }

    /**
     * Removes factories from the available factories
     * 
     * @param string[] $factoryNames 
     * 
     * @return void 
     * 
     * @throws InvalidArgumentException 
     * 
     */
    public static function removeFactories(string ...$factoryNames): void {
        static::$factories = array_reduce($factoryNames, function (array $acc, string $name): array {
            if (isset($acc[$name]) === false)
                throw new InvalidArgumentException("Lexer Factory '$name' does not exist");

            unset($acc[$name]);

            return $acc;
        }, static::$factories);
    }
}