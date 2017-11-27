<?php
//require_once '../spl_autoload_reg.php';

//Front controller

// 1. Общие настройки

// 2. Подключение файлов системы
require_once __DIR__ . '/../components/Router.php';
// 3. Соединение с БД

// 4. Вызов Router
$router = new Router();
$router->run();