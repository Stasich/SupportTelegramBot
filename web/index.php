<?php
require_once '../spl_autoload_reg.php';

use Controllers\MainController;
use Controllers\MessagesController;
use Controllers\WebhookController;
use Controllers\Router;
use Controllers\FailRoutController;
use Models\Stasich\ClassConfig;

$config = require '../src/config/config.php';
ClassConfig::setConfig($config);

$rout = new Router();
switch ($rout->get()) {
    case 'index':
        $response = new MainController();
        $response->indexAction();
        break;
    case 'messages':
        $response = new MessagesController();
        $response->indexAction();
        break;
    case 'webhook':
        $response = new WebhookController();
        $response->indexAction();
        break;
    default:
        $response = new FailRoutController();
        $response->indexAction();
}