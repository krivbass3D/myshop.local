<?php

include_once '../models/CategoriesModel.php'; //подключение модели категории
include_once '../models/ProductsModel.php'; //подключение модели продукті

/**
 * @param object $smarty
 */

function indexAction($smarty){

    $rsCategories = getAllMainCatsWithChildren();
    $rsProducts = getLastProducts(16);

    $smarty->assign('pageTitle', 'Главная страница');
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProducts', $rsProducts);
    loadTemplate($smarty,'header');
    loadTemplate($smarty,'index');
    loadTemplate($smarty,'footer');
}