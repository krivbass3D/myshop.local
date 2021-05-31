<?php

/**
 * Модель для таблицы заказов
 *
 */


function makeNewOrder ($name, $phone, $adress)
{
    include '../config/db.php'; // инициализация БД

    //инициализация переменніх
    $userId = $_SESSION['user']['id'];
    $comment = "id пользователя: {$userId} <br />
                Имя: {$name} <br />
                Тел: {$phone} <br />
                Адрес: {$adress} <br />";

    $dateCreated = date('Y.m.d H:i:s');
    $userIp = $_SERVER['REMOTE_ADDR'];

    //формирование запроса к БД
    $sql = "INSERT INTO 
                orders (`user_id`,`date_created`, `date_payment`,
                          `status`, `comment`, `user_ip`)
                VALUE ('{$userId}', '{$dateCreated}', null,
                        '0','{$comment}', '{$userIp}')";



    $rs = $mysqli->query($sql);

    // получить ID созданного заказа
    if ($rs){
        $sql = "SELECT id 
                FROM orders
                ORDER BY id DESC 
                LIMIT 1";

        $rs = $mysqli->query($sql);

        //преобразование результата запроса
        $rs = createSmartyRsArray($rs);

        //возвращаем ИД созданного заказа
        if (isset($rs[0])){
            return $rs[0]['id'];
        }

    }

    return false;
}

/**
 * Получить список заказов с привязкой к продуктам для пользователя $userId
 *
 * @param integer $userId ID пользователя
 * @return array массив заказов с привязкой к продуктам
 */
function getOrderWithProductsByUser($userId)
{
    include '../config/db.php'; // инициализация БД
    $userId = intval($userId);
    $sql = "SELECT * FROM orders
            WHERE `user_id` = '{$userId}'
            ORDER BY id DESC";

    $rs = $mysqli->query($sql);
    $r = $rs->fetch_row();
//d($r);
    $smartyRs = array();

    while ($row = $rs->fetch_assoc()){
        $rsChildren = getPurchaseForOrder($row['id']);

        if ($rsChildren){
            $row['children'] = $rsChildren;
            $smartyRs[]= $row;
        }
    }

    return $smartyRs;
}

function getOrders()
{

    include '../config/db.php'; // инициализация БД
    $sql = "SELECT o.*, u.name, u.email, u.phone, u.adress
            FROM orders AS `o`
            LEFT JOIN users AS `u` ON o.user_id = u.id
            ORDER BY id DESC";

    $rs = $mysqli->query($sql);

    while ($row = $rs->fetch_assoc()) {

        $rsChildren = getProductsForOrder ($row['id']);
       // d($rsChildren);
        if ($rsChildren){
            $row['children'] = $rsChildren;
            $smartyRs[] = $row;
        }

    }

    return $smartyRs;
}

function getProductsForOrder($orderId)
{
    include '../config/db.php'; // инициализация БД
    $sql = "SELECT *
            FROM purchase AS pe
            LEFT JOIN products AS ps
                ON pe.product_id = ps.id
            WHERE (`order_id` = '{$orderId}')";

    $rs = $mysqli->query($sql);

    return createSmartyRsArray($rs);
}

function updateOrderStatus($itemId, $status)
{
    include '../config/db.php'; // инициализация БД
    $status = intval($status);
    $sql = "UPDATE orders
            SET `status` = '{$status}'
            WHERE id= '{$itemId}'";

    $rs = $mysqli->query($sql);

    return $rs;
}

function updateOrederDatePayment($itemId, $datePayment)
{
    include '../config/db.php'; // инициализация БД

    $sql = "UPDATE orders
            SET `date_payment` = '{$datePayment}'
            WHERE id= '{$itemId}'";

    $rs = $mysqli->query($sql);
    return $rs;
}