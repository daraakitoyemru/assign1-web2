<?php

if (PHP_OS_FAMILY === 'Windows') {
    define('DBCONNSTRING', 'sqlite:./data/f1.db');
} else {
    define('DBCONNSTRING', 'sqlite:' . realpath(__DIR__ . '/../data/f1.db'));
}

//define('DBCONNSTRING', 'sqlite:../data/f1.db');
//define('DBCONNSTRING', 'sqlite:/Applications/XAMPP/xappfiles/htdocs/dakit711/assign1-web2/assign1/data/f1.db');
