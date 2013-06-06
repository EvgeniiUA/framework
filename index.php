<?php
/**
 * This is main file in application. 
 * A single entry point for the entire application. All request 
 * redirected to this file by dint of mod_rewrite.
 *
 * goal of this file:
 * initialization environment variables and run application.
 *
 * @author    Sinevid Evgenii
 * @copyright Copyright (c) 2013
 * @version   $Id$
 */
define('DEBUG', true);

require_once './framework/Application.php';

$config = './framework/defaultConfig.php';

// get application
$app = \framework\Application::getInstance($config);
$app->run();


