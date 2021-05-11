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
include_once '../models/OrdersModel.php';
include_once '../models/PurchaseModel.php';

function addtocartAction()
{
    $itemId = isset($_GET['id']) ? intval($_GET['id']) : null;
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


/**
 * Удаление продукта из корзины
 *
 *
 */
function removefromcartAction(){
    $itemId = isset($_GET['id']) ? intval($_GET['id']) : null;
    if (! $itemId) exit();

    $resData = array();
    $key = array_search($itemId, $_SESSION['cart']);
    if ($key !== false){
        unset($_SESSION['cart'][$key]);
        $resData['success'] = 1;
        $resData['cntItems'] = count($_SESSION['cart']);
    }else{
        $resData['success'] = 0;
    }

    echo json_encode($resData);
}


/**
 *Формирование страниы корзины
 *
 * @param $smarty
 */
function indexAction ($smarty){

    $itemsIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();

    $rsCategories = getAllMainCatsWithChildren();
    $rsProducts = getProductsFromArray($itemsIds);

    $smarty->assign('pageTitle', 'Корзина');
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProducts', $rsProducts);

    loadTemplate($smarty,'header');
    loadTemplate($smarty,'cart');
    loadTemplate($smarty,'footer');

}

function orderAction($smarty){
    //получаем массив идентификаторов
    $itemsIds = isset($_SESSION['cart']) ? $_SESSION['cart'] : null;
    if (! $itemsIds){
        redirect('/cart/');
        return;
    }

    //получаем из массива РОСТ кол-во покупаемых товаров
    $itemsCnt = array();
    foreach ($itemsIds as $item){
        //формируем ключ для масива РОСТа
        $postVar = 'itemCnt_' . $item;
        // создаем элем. массива кол-ва покупаемого товара
        // ключ массива -ID товара, значение массива - кол-во товара
        // $itemsCnt[1] = 3; товар с ID == 1 покупают 3 шт
        $itemsCnt[$item] = isset($_POST[$postVar]) ? $_POST[$postVar] : null;
    }

    // получаем список продуктов по массиву корзины
    $rsProducts = getProductsFromArray($itemsIds);

    //добавляем каждому продукту дополнительное поле
    //realPrice = кол-во продуктов * на цену товара
    //cnt = кол-во покупаемого товара

    //&$item - для того чтобі при изменении переменой $item менялся и єлемент массива $rsProducts
    $i=0;
    foreach ($rsProducts as &$item){
        $item['cnt'] = isset($itemsCnt[$item['id']]) ? $itemsCnt[$item['id']] : 0;
        if($item['cnt']){
            $item['realPrice'] = $item['cnt'] * $item['price'];
        }else{
            //если вдруг получилось так что товар в корзине есть, а кол-во == нулю то удаляем товар
            unset($rsProducts[$i]);
        }
        $i++;
    }

    if (! $rsProducts){
        echo "Корзина пуста";
        return;
    }

    //полученный массив покупаемых товаров помещаем в сессионую переменную
    $_SESSION['saleCart'] = $rsProducts;

    $rsCategories = getAllMainCatsWithChildren();

    //hideLoginBox переменная флаг для того чтобі спрятать блоки логина и регистрации в боковой панели
    if (! isset($_SESSION['user'])){
        $smarty->assign('hideLoginBox',1);
    }

    $smarty->assign('pageTitle','Заказ');
    $smarty->assign('rsCategories', $rsCategories);
    $smarty->assign('rsProducts', $rsProducts);


    loadTemplate($smarty,'header');
    loadTemplate($smarty,'order');
    loadTemplate($smarty,'footer');

 }


/**
 * AJAX функция сохранения заказа
 *
 * @param  array $_SESSION['saleCart'] массив покупаемых продуктов
 * @return json инфа о результате віполнения
 *
 */
 function saveorderAction()
{
    // получаем массив покупаемых товаров
    $cart = isset($_SESSION['saleCart']) ? $_SESSION['saleCart'] : null;
    //если корзина пуста формируем отчет с ошибкой в формате json
    if(! $cart){
        $resData['success'] = 0;
        $resData['message'] = 'Нет товаров для заказа';
        echo json_encode($resData);
        return;
    }

    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $adress = $_POST['adress'];

    //создаем новый заказ и получаем его ID
    $orderId = makeNewOrder($name, $phone, $adress);

    //если заказ не создан, то выдаем ошибку и завершаем функцию
    if(! $cart){
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка создания заказа';
        echo json_encode($resData);
        return;
    }

    //сохраняем товары для созданного заказа
    $res = setPurchaseForOrder($orderId, $cart);

    if($res){
        $resData['success'] = 1;
        $resData['message'] = 'Заказ сохранен';
        unset($_SESSION['saleCart']);
        unset($_SESSION['cart']);
    }else{
        $resData['success'] = 0;
        $resData['message'] = 'Ошибка внесения данных для заказа № ' . $orderId;
    }

    echo json_encode($resData);

}