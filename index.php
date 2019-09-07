<?php
error_reporting(E_ALL);
// comment out the following two lines when deployed to production

  defined('UNI_DEBUG') or define('UNI_DEBUG', true);
  defined('UNI_ENV') or define('UNI_ENV', 'dev');

require(__DIR__ . '/vendor/autoload.php');
require(__DIR__ . '/vendor/unibox/uni/Uni.php');
Uni::setAlias("rootPath",__DIR__);
$config = require(__DIR__ . '/app/config/web.php');

(new uni\web\Application($config))->run();
