<?php

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT')) {
    define('ROOT', dirname(dirname(__FILE__)));
}
if (!defined('WEBROOT')) {
    define('WEBROOT', ROOT.DS."webroot");
}

function autoloadClasses($class) {

    $pos_start = strripos($class, '\\');
    $pos_end = strlen($class);
    $class_name = substr(ltrim($class), $pos_start, $pos_end);
    $file_class = ROOT . DS . str_replace('\\', DS, strtolower($class_name)) . '.class.php';
    $file_exception = ROOT . DS . 'exceptions'. DS . str_replace('\\', DS, strtolower($class)) . '.class.php';

    if($pos_start) {
        if (is_readable($file_class)) {
            require_once "$file_class";
        }
    }
    else if (is_readable($file_exception)){
        require_once "$file_exception";
    }
    else {
        throw new Exception('Failed to include class '. $class_name);
    }
}

spl_autoload_register('autoloadClasses');

