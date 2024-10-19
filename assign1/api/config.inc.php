<?php

if (PHP_OS_FAMILY === 'Windows') {
    define('DBCONNSTRING', 'sqlite:../data/f1.db');
} else {
    define('DBCONNSTRING', 'sqlite:' . realpath(__DIR__ . '/../data/f1.db'));
}

?>