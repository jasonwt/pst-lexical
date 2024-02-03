<?php


/*TDD*/

declare(strict_types=1);

require_once(__DIR__ . "/../../../../vendor/autoload.php");

use PST\Testing\Exceptions\ShouldException;
use PST\Lexical\Implementations\SQL\SQLLexerFactory;
use PST\Lexical\Implementations\SQL\SQLPatterns;
use PST\Testing\Should;

PST\Debugging\dp('test');

use function PST\Debugging\dp;

try {
    //$sql = "schema.table.column as alias, schema2.table2.column2 as alias2";
    $sql = "    schema.table.column      as alias, s.t.c as a 'asdfasdf' a.b.c";
    $sql = "  z.y.x,  schema.table.column      as alias, s.t.c as a.b.c.d";
    $sql = "  z.y.x,  a.b.c as d, 'this is a test','test2''test3' ";
    //$sql = "schema.table.column,";

    $lexer = SQLLexerFactory::instantiate('SELECT_EXPRESSION', $sql);

    dp($lexer->tokens());



/*    
    function mat($pattern, $sql, $offset = 0) {
        $pattern = '/^' . $pattern . '/i';
        echo "pattern: $pattern\n";
        
        if (preg_match($pattern, substr($sql, $offset), $matches)) {
            print_r($matches);
            return $matches;
        } 

        return null;
    }

    $offset = 0;
    echo "sql: '" . substr($sql, $offset) . "'\n";

    $results = mat('\s+', $sql, $offset);
    $offset += strlen($results[0]);
    echo "sql: '" . substr($sql, $offset) . "'\n";

    $results = mat(SQLPatterns::COLUMN_IDENTIFIER, $sql, $offset);
    $offset += strlen($results[0]);
    echo "sql: '" . substr($sql, $offset) . "'\n";

    $results = mat('\s+', $sql, $offset);
    $offset += strlen($results[0]);
    echo "sql: '" . substr($sql, $offset) . "'\n";

    $results = mat(SQLPatterns::ALIAS_IDENTIFIER, $sql, $offset);
    $offset += strlen($results[0]);
    echo "sql: '" . substr($sql, $offset) . "'\n";

    $results = mat('[,]{1}', $sql, $offset);
    $offset += strlen($results[0]);
    echo "sql: '" . substr($sql, $offset) . "'\n";
*/
    
    







/*      
    class C {
        private int $priv = 100;
        protected float $prot = 200.0;
        public string $pub = "300";

        public array $arr = [1, "two" => 2, 3];
    }

    $arr = [
        "zero",
        "one" => "one",
        2 => "two",
        "three" => "three",
        "four" => new C(),
    ];

    dp($arr);
*/
/*    

    $str = "  one";
    $pattern = '(\w+)(?:\s*|,|$)';
    $pattern = '(\s+)';
    $pattern = '/^' . $pattern . '/';
    echo "pattern: $pattern\n";
    if (preg_match($pattern, $str, $matches))
        var_dump($matches);
*/    
} catch (ShouldException $e) {
    dp($e->getMessage());

} catch (\Throwable $e) {
    throw $e;
}