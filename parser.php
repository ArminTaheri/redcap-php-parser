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
        private $expression;
        private $tokens;
        private $offset;
        private $backtrack;
        function __construct($expression) {
            $this->expression = $expression;
            $this->tokens = Lexer::lex($expression);
            $this->offset = 0;
            $this->backtrack = $this->offset;
        }
        function parse() {
            $ast = $this->parseBoolTerm();
            if ($ast === false) {
                throw new Exception("Cannot parse expression.");
            }
            return $ast;
        }
        function next() {
            $this->offset += 1;
            if ($this->offset > count($this->tokens)) {
                throw new Exception("Invalid expression ending: " . $this->expression);
            }
        }
        function setBacktrack() {
          $this->backtrack = $this->offset;
        }
        function backtrack() {
          $this->offset = $this->backtrack;
        }
        function expect($token) {
            if ($this->offset >= count($this->tokens)) {
                return false;
            }
            $currentTok = $this->tokens[$this->offset];
            if ($currentTok['token'] !== $token) {
                return false;
            }
            return $currentTok['match'];
        }
        function parseBoolTerm() {
            $left = $this->parseUnaryBool();
            $op = $this->expect('and') || $this->expect('or');
            if ($op === false) {
                return $left;
            }
            $this->next();
            $right = $this->parseBoolTerm();
            return array(
                'tag' => 'BinaryOp',
                'op' => $op,
                'args' => array($left, $right),
            );
        }
        function parseUnaryBool() {
            $op = $this->expect("not");
            if ($op === false) {
                return $this->parseBoolComp();
            }
            $this->next();
            $arg = $this->parseBoolComp();
            return array(
                'tag' => 'UnaryOp',
                'op' => $op,
                'args' => array($arg),
            );
        }
        function parseBoolComp() {
            $left = $this->parseNumTerm();
            $filt = array_filter(["=", "<", ">", "<>", "<=", ">="], array($this, 'expect'));
            if (count($filt) === 0) {
                return $left;
            }
            $this->next();
            $op = $filt[0];
            if ($op === false) {
                return $left;
            }
            $right = $this->parseBoolComp();
            return array(
                'tag' => 'BinaryOp',
                'op' => $op,
                'args' => array($left, $right),
            );
        }
        function parseNumTerm() {
            $left = $this->parseNumFactor();
            $filt = array_filter(["+", "-"], array($this, 'expect'));
            if (count($filt) === 0) {
                return $left;
            }
            $this->next();
            $op = $filt[0];
            $right = $this->parseNumTerm();
            return array(
                'tag' => 'BinaryOp',
                'op' => $op,
                'args' => array($left, $right),
            );
        }
        function parseNumFactor() {
            $left = $this->parseNumPower();
            $filt = array_filter(["*", "/"], array($this, 'expect'));
            if (count($filt) === 0) {
                return $left;
            }
            $this->next();
            $op = $filt[0];
            $right = $this->parseNumFactor();
            return array(
                'tag' => 'BinaryOp',
                'op' => $op,
                'args' => array($left, $right),
            );
        }
        function parseNumPower() {
            $left = $this->parseUnaryFact();
            $op = $this->expect("^");
            if ($op === false) {
                return $left;
            }
            $this->next();
            $op = $filt[0];
            $right = $this->parseNumPower();
            return array(
                'tag' => 'BinaryOp',
                'op' => $op,
                'args' => array($left, $right),
            );
        }
        function parseUnaryFact() {
            $arg = $this->parseUnaryPercent();
            $op = $this->expect("%");
            if ($op === false) {
                return $arg;
            }
            $this->next();
            return array(
                'tag' => 'UnaryOp',
                'op' => $op,
                'args' => array($arg),
            );
        }
        function parseUnaryPercent() {
            $arg = $this->parseUnaryMinus();
            $op = $this->expect("%");
            if ($op === false) {
                return $arg;
            }
            $this->next();
            return array(
                'tag' => 'UnaryOp',
                'op' => $op,
                'args' => array($arg),
            );
        }
        function parseUnaryMinus() {
            $op = $this->expect("-");
            if ($op === false) {
                return $this->parseLiteral();
            }
            $this->next();
            $arg = $this->parseLiteral();
            return array(
                'tag' => 'UnaryOp',
                'op' => $op,
                'args' => array($arg),
            );
        }
        function parseLiteral() {
            return (
//                $this->parseFuncCall() ||
//                $this->parseBracketted() ||
                $this->parseNumber()
//                $this->parseString() ||
//                $this->parseConstant()
            );
        }
        function parseNumber() {
            $num = $this->expect("NUMBER");
            if ($num === false) {
                return false;
            }
            $this->next();
            return array(
                'tag' => 'Literal',
                'args' => array($num),
            );
        }
    }
?>
