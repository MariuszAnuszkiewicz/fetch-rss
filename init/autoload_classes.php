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

    $class_name = ltrim($class, '\\');
    $pos_start = strlen($class_name);
    $file_exception = ROOT.DS.'exceptions'.DS.str_replace('\\', DS, strtolower($class_name)) . '.class.php';

    if ($pos_end = strripos($class, '\\')) {

        $namespace = substr($class, $pos_start, $pos_end);
        $class_name = substr($class, $pos_end + 1);
        $file_class = str_replace('\\', DS, $namespace);
        $file_class .= ROOT . DS . str_replace('\\', DS, strtolower($class_name)) . '.class.php';

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
