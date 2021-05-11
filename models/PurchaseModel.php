<?php
/**
 * Модель для таблицы продуктов
 *
 */


function setPurchaseForOrder($orderId, $cart)
{
    include '../config/db.php'; // инициализация БД

    $sql = "INSERT INTO purchase
            (order_id, product_id, price, amount)
            VALUES ";

    $values = array();
    //формируем массив строк для запроса для каждого товара
    foreach ($cart as $item){
        $values[] = "('{$orderId}','{$item['id']}','{$item['price']}','{$item['cnt']}')";
    }

    // преобразовываем массив в строку
    $sql .= implode($values, ', ');
    $rs = $mysqli->query($sql);

    return $rs;
}

function getPurchaseForOrder($orderId)
{
    include '../config/db.php'; // инициализация БД
    $sql = "SELECT `pe`.*, `ps` . `name`
            FROM purchase as `pe`
            JOIN products as `ps` ON `pe`.product_id = `ps`.id
            WHERE `pe` . order_id = {$orderId}";

    $rs = $mysqli->query($sql);
    return createSmartyRsArray($rs);
}