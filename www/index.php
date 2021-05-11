<?php
session_start();

if(! isset($_SESSION['cart']))
{
    $_SESSION['cart']=array();
}

include_once '../config/config.php'; // инициализация настроек
include_once '../config/db.php'; // инициализация БД
include_once '../library/mainFunction.php'; // Основные функции

// определяем контроллер и функцию с кокой будем работать
$controllerName = isset($_GET['controller']) ? ucfirst($_GET['controller']) : 'Index';
$actionName = isset($_GET['action']) ? $_GET['action'] : 'index';

// если в сессии есть данные об авторизации пользователя то передаем их в шаблон
if(isset($_SESSION['user'])){
    $smarty->assign('arUser', $_SESSION['user']);
}

//инициализируем переменную шаблонизатора кол-ва эл-тов в корзине
$smarty->assign('cartCntItems', count($_SESSION['cart']));

loadPage($smarty, $controllerName,$actionName);