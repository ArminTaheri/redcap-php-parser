<?php
$FUNCTIONS = array(
    'eq' => function ($a, $b) {
        return $a == $b;
    },
    'neq' => function ($a, $b) {
        return $a != $b;
    },
    'gt' => function ($a, $b) {
        return $a > $b;
    },
    'lt' => function ($a, $b) {
        return $a < $b;
    },
    'geq' => function ($a, $b) {
        return $a >= $b;
    },
    'leq' => function ($a, $b) {
        return $a >= $b;
    },
    'add' => function ($a, $b) {
        return $a + $b;
    },
    'sub' => function ($a, $b) {
        return $a - $b;
    },
    'mul' => function ($a, $b) {
        return $a * $b;
    },
    'div' => function ($a, $b) {
        return $a / $b;
    },
    'pow' => function ($a, $b) {
        return $a ** $b;
    },
    'mod' => function ($a, $b) {
        return $a % $b;
    },
    'negate' => function ($a) {
        return -$a;
    },
    'per' => function ($a) {
        return $a / 100;
    },
    'and' => function ($a, $b) {
        return $a and $b;
    },
    'or' => function ($a, $b) {
        return $a or $b;
    },
    'not' => function ($a) {
        return !$a;
    },
    'fact' => function ($a) {
        if ($a >=0 && $a%1 == 0) {
            return factHelper1($a);
        } else if ($a >=0 && $a%1 == 0.5) {
            return factHelper2($a);
        } else {
            throw "Factorial for a number not divisible by 0.5 or greater than 0 is not supported.";
        }
    },
    'actHelper1' => function ($n) {
        if ($n == 0) return 1;
        return rec($n-1)*$n;
    },
    'actHelper2' => function ($n) {
        if ($n == 0.5) return sqrt(M_PI)/2;
        return rec($n-1)*$n;
    },
    'isNan' => function ($a) {
        return is_nan($a);
    },
    'round' => function ($n, $places) {
        $shift = 10 ** $places;
        return round($n * $shift) / $shift;
    },
    'roundup' => function ($n, $places) {
        $shift = 10 ** $places;
        return ceil($n * $shift) / $shift;
    },
    'rounddown' => function ($n, $places) {
        $shift = 10 ** $places;
        return floor($n * $shift) / $shift;
    },
    'sqrt' => function ($a) {
        return sqrt($a);
    },
    'abs' => function ($a) {
        return abs($a);
    },
    'min' => function () {
        $args = func_get_args();
        return min($args);
    },
    'max' => function () {
        $args = func_get_args();
        return max($args);
    },
    'mean' => function () {
        $args = func_get_args();
        if (count($args) == 0) throw "Cannot find mean of 0 arguments";
        return array_reduce($args, function($a, $b){ return $a+$b; }, 0) / count($args);
    },
    'median' => function () {
        $args = func_get_args();
        if (count($args) == 0) throw "Cannot find median of 0 arguments";
        $cpy = array_map(function($x){return $x;}, $args);
        $mid = count($cpy) / 2;
        sort($cpy);
        if(count($cpy) % 2 == 0) {
            return ($cpy[$mid] + $cpy[$mid + 1]) / 2;
        } else {
            return $cpy[$mid + 1];
        }
    },
    'sum' => function () {
        $args = func_get_args();
        return array_reduce($args, function($a, $b){ return $a+$b; }, 0);
    },
    'product' => function () {
        $args = func_get_args();
        return array_reduce($args, function($a, $b){ return $a*$b; }, 1);
    },
    'variance' => function () {
        $args = func_get_args();
        $mean = array_reduce($args, "_sum") / count($args);
        $sqDiffs = array_map(function($value) { return ($value-$mean)**2; }, $args);
        return array_reduce($sqDiffs, function($a, $b){ return $a+$b; }, 0) / count($args);
    },
    'stdev' => function () {
        $args = func_get_args();
        $mean = array_reduce($args, "_sum") / count($args);
        $sqDiffs = array_map(function($value) { return ($value-$mean)**2; }, $args);
        $variance = array_reduce($sqDiffs, function($a, $b){ return $a+$b; }, 0) / count($args);
    	  return sqrt($variance);
    },
    'datediff' => function ($date1, $date2, $units, $returnSigned=false) {
        $dt1 = new DateTime($date1);
        $dt2 = new DateTime($date2);
        $interval = date_diff($dt1, $dt2, !$returnSigned);
        //deal with units
        return $interval->format("%$units");
    }
);
?>
