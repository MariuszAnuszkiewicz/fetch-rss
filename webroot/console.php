<?php
use MariuszAnuszkiewicz\src\Input\InputField;
use MariuszAnuszkiewicz\src\Fetch\FetchData;

if (!defined('DS')) {
    define('DS', DIRECTORY_SEPARATOR);
}
if (!defined('ROOT')) {
    define('ROOT', dirname(dirname(__FILE__)));
}

require_once(ROOT.DS.'init'.DS.'autoload_classes.php');
require_once(WEBROOT.DS.'forms/add_canals.php');

$url = InputField::load('feed_url');

$rss_data =  new FetchData();

if (preg_match_all('/^(http:\/\/feeds|https:\/\/feeds)/', $url)) {
    if (InputField::load('submit')) {
        ?>
         <div id="submit_alert">
        <?php
            echo "<p>DONE!</p>";
        ?>
         </div>
        <?php
    }
}

   $rss_data->run($url, "on");
