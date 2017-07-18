<?php
    include 'functions.php';
    include 'parser.php';

    var_dump((new Parser($argv[1]))->parse());
?>
