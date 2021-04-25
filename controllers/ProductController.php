<?php
/**
 *
 * Контроллер страницы товара (/product/1)
 *
 *
 */

//Подключаем модели
include_once '../models/CategoriesModel.php';
include_once '../models/ProductsModel.php';


/**
 * Формирование страницы продукта
 *
 * @param $smarty
 */

function indexAction ($smarty){

    $itemId = isset($_GET['id']) ? $_GET['id'] : null;
    if ($itemId == null) exit();

    //получить данные продукта
    $rsProduct = getProductById($itemId);

    //получить все категории
    $rsCategories = getAllMainCatsWithChildren();


    //если главная категория то показіваем дочернии категории
    //иначе показіваем товар


    $smarty->assign('pageTitle', '');
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProduct', $rsProduct);

    loadTemplate($smarty,'header');
    loadTemplate($smarty,'product');
    loadTemplate($smarty,'footer');

}