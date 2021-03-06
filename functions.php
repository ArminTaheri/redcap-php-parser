<?php
$FUNCTIONS = array(
    '_eq' => function ($a, $b) {
        return $a == $b;
    },
    '_neq' => function ($a, $b) {
        return $a != $b;
    },
    '_gt' => function ($a, $b) {
        return $a > $b;
    },
    '_lt' => function ($a, $b) {
        return $a < $b;
    },
    '_geq' => function ($a, $b) {
        return $a >= $b;
    },
    '_leq' => function ($a, $b) {
        return $a >= $b;
    },
    '_add' => function ($a, $b) {
        return $a + $b;
    },
    '_sub' => function ($a, $b) {
        return $a - $b;
    },
    '_mul' => function ($a, $b) {
        return $a * $b;
    },
    '_div' => function ($a, $b) {
        return $a / $b;
    },
    '_pow' => function ($a, $b) {
        return $a ** $b;
    },
    '_mod' => function ($a, $b) {
        return $a % $b;
    },
    '_negate' => function ($a) {
        return -$a;
    },
    '_per' => function ($a) {
        return $a / 100;
    },
    '_and' => function ($a, $b) {
        return $a and $b;
    },
    '_or' => function ($a, $b) {
        return $a or $b;
    },
    '_not' => function ($a) {
        return !$a;
    },
    '_fact' => function ($a) {
        if ($a >=0 && $a%1 == 0) {
            return factHelper1($a);
        } else if ($a >=0 && $a%1 == 0.5) {
            return factHelper2($a);
        } else {
            throw "Factorial for a number not divisible by 0.5 or greater than 0 is not supported.";
        }
    },
    '_actHelper1' => function ($n) {
        if ($n == 0) return 1;
        return rec($n-1)*$n;
    },
    '_actHelper2' => function ($n) {
        if ($n == 0.5) return sqrt(M_PI)/2;
        return rec($n-1)*$n;
    },
    '_isNan' => function ($a) {
        return is_nan($a);
    },
    '_round' => function ($n, $places) {
        $shift = 10 ** $places;
        return round($n * $shift) / $shift;
    },
    '_roundup' => function ($n, $places) {
        $shift = 10 ** $places;
        return ceil($n * $shift) / $shift;
    },
    '_rounddown' => function ($n, $places) {
        $shift = 10 ** $places;
        return floor($n * $shift) / $shift;
    },
    '_sqrt' => function ($a) {
        return sqrt($a);
    },
    '_abs' => function ($a) {
        return abs($a);
    },
    '_min' => function () {
        $args = func_get_args();
        return min($args);
    },
    '_max' => function () {
        $args = func_get_args();
        return max($args);
    },
    '_mean' => function () {
        $args = func_get_args();
        if (count($args) == 0) throw "Cannot find mean of 0 arguments";
        return array_reduce($args, function($a, $b){ return $a+$b; }, 0) / count($args);
    },
    '_median' => function () {
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
    '_sum' => function () {
        $args = func_get_args();
        return array_reduce($args, function($a, $b){ return $a+$b; }, 0);
    },
    '_product' => function () {
        $args = func_get_args();
        return array_reduce($args, function($a, $b){ return $a*$b; }, 1);
    },
    '_variance' => function () {
        $args = func_get_args();
        $mean = array_reduce($args, "_sum") / count($args);
        $sqDiffs = array_map(function($value) { return ($value-$mean)**2; }, $args);
        return array_reduce($sqDiffs, function($a, $b){ return $a+$b; }, 0) / count($args);
    },
    '_stdev' => function () {
        $args = func_get_args();
        $mean = array_reduce($args, "_sum") / count($args);
        $sqDiffs = array_map(function($value) { return ($value-$mean)**2; }, $args);
        $variance = array_reduce($sqDiffs, function($a, $b){ return $a+$b; }, 0) / count($args);
    	  return sqrt($variance);
    },
    '_datediff' => function ($date1, $date2, $units, $returnSigned=false) {
        $dt1 = new DateTime($date1);
        $dt2 = new DateTime($date2);
        $interval = date_diff($dt1, $dt2, !$returnSigned);
        //deal with units
        return $interval->format("%$units");
    }
);
?>
