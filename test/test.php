#!/bin/php
<?php

require_once '../vendor/autoload.php';

// Get all dirs
$dirs = glob('./*', GLOB_ONLYDIR);

$passed = 0;
foreach ($dirs as $dir) {
    $dirname = basename($dir);
    echo 'Testing ' . $dirname . ' ';

    require_once $dir . '/' . $dirname . 'Test.php';

    $class = 'Gashmob\\YamlEditor\\Test\\' . $dirname . '\\' . $dirname . 'Test';
    $test = new $class();
    $result = $test->run();

    if ($result) {
        echo "\033[42m PASS \033[0m\n";
        $passed++;
    } else {
        echo "\033[41m FAIL \033[0m\n";
    }
}

echo "\n";
echo 'Passed: ' . $passed . '/' . count($dirs) . "\n";
if ($passed == count($dirs)) {
    echo "\033[42m ALL TESTS PASSED \033[0m\n";
    exit(0);
} else {
    echo "\033[41m SOME TESTS FAILED \033[0m\n";
    exit(1);
}