<?php

/**
 *
 * Контроллер работы с корзиной (/cart/)
 *
 *
 *
 */


//Подключаем модели
include_once '../models/CategoriesModel.php';
include_once '../models/ProductsModel.php';

function addtocartAction()
{
    $itemId = isset($_GET['id']) ? intval($_GET['id']) : null;
    var_dump($itemId);
    exit();
    if(! $itemId) return false;

    $resData =  array();

    //если значение не найдено то добавляем
    if (isset($_SESSION['cart']) && array_search($itemId, $_SESSION['cart'])===false){
        $_SESSION['cart'][]=$itemId;
        $resData['cntItem']= count($_SESSION['cart']);
        $resData['success'] = 1;
    } else {
        $resData['success'] = 0;
    }

    echo json_encode($resData);
}