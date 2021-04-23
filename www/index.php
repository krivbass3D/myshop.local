<?php

include_once '../config/config.php'; // инициализация настроек
include_once '../library/mainFunction.php'; // Основные функции

// определяем контроллер и функцию с кокой будем работать
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) : 'Index';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

loadPage($smarty, $controllerName,$actionName);