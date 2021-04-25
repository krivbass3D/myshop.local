<?php
/**
 *
 * Контроллер страницы категории
 *
 *
 */

//Подключаем модели
include_once '../models/CategoriesModel.php';
include_once '../models/ProductsModel.php';

/**
 * Формирование страницы категории
 *
 * @param object $smarty шаблонизатор
 *
 *
 */

function indexAction ($smarty){

    $catId = isset($_GET['id']) ? $_GET['id'] : null;
    if ($catId == null) exit();

    $rsProducts = null;
    $rsChildCats = null;

    $rsCategory = getCatById($catId);

    //если главная категория то показіваем дочернии категории
    //иначе показіваем товар



    if($rsCategory['parent_id']==0){
        $rsChildCats = getChildrenForCat($catId);
    }else{
        $rsProducts = getProductsByCat ($catId);
    }

    $rsCategories = getAllMainCatsWithChildren();

    //d($rsCategory);
    $smarty->assign('pageTitle', 'Товарі категории ' . $rsCategory['name']);
    $smarty->assign('pageTitle', 'Товары категории ' . $rsCategory['name']);

    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProducts', $rsProducts);
    $smarty->assign('rsChildCats', $rsChildCats);
    $smarty->assign('rsCategory', $rsCategory);

    loadTemplate($smarty,'header');
    loadTemplate($smarty,'category');
    loadTemplate($smarty,'footer');

}