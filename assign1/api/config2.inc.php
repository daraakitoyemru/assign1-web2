<?php
if (PHP_OS_FAMILY === 'Windows') {
    define('DBCONNSTRING2', 'sqlite:./data/f1.db');
} else {
    define('DBCONNSTRING2', 'sqlite:' . realpath(__DIR__ . '/../data/f1.db'));
}