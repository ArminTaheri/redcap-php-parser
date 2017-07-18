<?php
    include "lexer.php";

    $opPrecs = array(
        array("left", 2, "and", "or"),
        array("left", 2, "=", "<", ">", "<>", "<=", ">="),
        array("left", 2, "+", "-"),
        array("left", 2, "*", "/"),
        array("left", 2, "^"),
        array("right", 1, "not"),
        array("left", 1, "!"),
        array("left", 1, "%"),
        array("right", 1, "-"),
    );
    class Parser {
        function __construct($expression) {
            $this->$expression = $expression;
            $this->$tokens = Lexer.lex($expression);
            $this->$offset = -1;
        }
        function parse() {
            return $this->parseExpression();
        }
        function next() {
            $this-$offset += 1;
            if ($this->$offset > count($this->$tokens)) {
                throw new Exception("Invalid expression: " . $this->$expression);
            }
        }
        function expect($token) {
            $currentTok = $this->$tokens[$this->offset];
            if ($currentTok['token'] !== $token) {
                return false;
            }
            return $currentTok['match'];
        }
        function parseExpression() {
            $left = $this->parseBoolComp();
            $op = $this->$expect('and') || $this->$expect('or');
            $this->next();
            if ($op === false) {
                return $left;
            }
            $right = $this->parseExpression();
            return array(
                'type' => 'BinaryOp',
                'op' => $op,
                'args' => array($left, $right),
            );
        }
        function parseBoolComp() {
            $left = $this->parseNumTerm();
            $filt = array_filter("=", "<", ">", "<>", "<=", ">=", $this->expect);
            $this->next();
            if ($filt.length === 0) {
                return false;
            }
            $op = $filt[0];
            if ($op === false) {
                return $left;
            }
            $right = $this->parseBoolComp();
            return array(
                'type' => 'BinaryOp',
                'op' => $op,
                'args' => array($left, $right),
            );
        }
        function parseNumTerm() {
            $left = $this->parseNumFactor();
            $filt = array_filter("+", "-", $this->expect);
            $this->next();
            if ($filt.length === 0) {
                return false;
            }
            $op = $filt[0];
            $right = $this->parseNumTerm();
            return array(
                'type' => 'BinaryOp',
                'op' => $op,
                'args' => array($left, $right),
            );
        }
        function parseNumFactor() {
            $left = $this->parseNumFactor();
            $filt = array_filter("+", "-", $this->expect);
            $this->next();
            if ($filt.length === 0) {
                return false;
            }
            $op = $filt[0];
            $right = $this->parseNumTerm();
            return array(
                'type' => 'BinaryOp',
                'op' => $op,
                'args' => array($left, $right),
            );
        }
    }
?>
