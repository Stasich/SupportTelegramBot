<?php
require_once '../spl_autoload_reg.php';
require_once '../src/config/config.php';

use Controllers\MainController;
use Controllers\MessagesController;
use Controllers\WebhookController;
use Controllers\Router;
use Controllers\FailRoutController;

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