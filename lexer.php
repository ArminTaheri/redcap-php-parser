<?php
    class Lexer {
        private static $terminals = array(
            "/^null/" => "null",
            "/^true/" => "true",
            "/^false/" => "false",
            "/^E/" => "E",
            "/^PI/" => "PI",
            "/^\d+(\.\d+)?\b/" => "NUMBER",
            "/^[*]/" => "*",
            "/^\//" => "/",
            "/^[-]/" => "-",
            "/^[+]/" => "+",
            "/^\^/" => "^",
            "/^[=]/" => "=",
            "/^[!]/" => "!",
            "/^[%]/" => "%",
            "/^\(/" => "(",
            "/^\)/" => ")",
            "/^[,]/" => ",",
            "/^\<\>/" => "<>",
            "/^\<[=]/" => "<=",
            "/^\>[=]/" => ">=",
            "/^\</" => "<",
            "/^\>/" => ">",
            "/^and/" => "and",
            "/^or/" => "or",
            "/^not/" => "not",
            "/^[_a-zA-Z0-9]\w*/" => "VARIABLE",
            "/^\"[^\"]*\"/" => "ESTRING",
            "/^\'[^\']*\'/" => "STRING",
            "/^\[/" => "[",
            "/^\]/" => "]"
        );
        function match($expression, $offset) {

        }
        function lex($expression) {
            $tokens = array();
            $offset = 0;
            while($offset < strlen($expression)) {

            }
        }
    }
?>
