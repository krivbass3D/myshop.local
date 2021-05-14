<?php

/**
 *
 * Модель для таблицы products
 *
 *
 * @param null $limit
 * @return array|false
 */

function getLastProducts ($limit = null)
{
    include '../config/db.php'; // инициализация БД

    $sql = "SELECT *
            FROM products
            ORDER BY id DESC";

    if($limit){
        $sql .= " LIMIT {$limit}";
    }

    $rs = $mysqli->query($sql);

    return createSmartyRsArray($rs);
}

/**
 * Получить продукты для категории
 *
 * @param integer $itemId ID категории
 * @return array|false
 */
function getProductsByCat ($itemId)
{
    include '../config/db.php'; // инициализация БД
    $itemId = intval($itemId);
    $sql = "SELECT *
                FROM products
                WHERE category_id = '{$itemId}'
        ";

    $rs = $mysqli->query($sql);

    return createSmartyRsArray($rs);
}

/**
 * Получить данные пордукта по ID
 *
 * @param $itemId
 * @return mixed
 */
function getProductById ($itemId)
{
    include '../config/db.php'; // инициализация БД
    $itemId = intval($itemId);
    $sql = "SELECT *
                FROM products
                WHERE id = '{$itemId}'
        ";

    $rs = $mysqli->query($sql);
    return $rs->fetch_assoc();
}

/**
 * Получить список продуктов из массива идентификаторов
 *
 * @param $itemsIds
 * @return array|false
 */
function getProductsFromArray ($itemsIds)
{
    include '../config/db.php'; // инициализация БД

    $strIds = implode( ',',$itemsIds);
    $sql = "SELECT *
            FROM products
            WHERE id in ({$strIds})
    ";
    $rs = $mysqli->query($sql);

    return createSmartyRsArray($rs);
}

/**
 * Получить все продукты
 *
 * @param $itemId
 * @return mixed
 */
function getProducts()
{
    include '../config/db.php'; // инициализация БД

    $sql = "SELECT *
                FROM `products`
                ORDER BY category_id";

    $rs = $mysqli->query($sql);

    return createSmartyRsArray($rs);
}

function insertProduct($itemName, $itemPrice, $itemDesc, $itemCat)
{
    include '../config/db.php'; // инициализация БД
    $sql = "INSERT INTO 
                products (`category_id`,`name`, `description`,
                          `price`)
                VALUE ('{$itemCat}', '{$itemName}','{$itemDesc}', '{$itemPrice}')";

    $rs = $mysqli->query($sql);

    return $rs;
}

function updateProduct($itemId, $itemName, $itemPrice, $itemStatus, $itemDesc, $itemCat, $newFileName = null)
{
    include '../config/db.php'; // инициализация БД
    //$set[] = array();

    if($itemName){
        $set[] = "`name` = '{$itemName}'";
    }

    if($itemPrice>0){
        $set[] = "`price` = '{$itemPrice}'";
    }

    if($itemStatus !==null){
        $set[] = "`status` = '{$itemStatus}'";
    }

    if($itemDesc){
        $set[] = "`description` = '{$itemDesc}'";
    }

    if($itemCat){
        $set[] = "`category_id` = '{$itemCat}'";
    }

    if($newFileName){
        $set[] = "`image` = '{$newFileName}'";
    }

    $setStr = implode(", ", $set);

    $sql = "UPDATE products
            SET {$setStr}
            WHERE id = '{$itemId}'";

    $rs = $mysqli->query($sql);

    return $rs;

}

function updateProductImage($itemId, $newFileName)
{
    d($newFileName);
    $rs = updateProduct($itemId,null,null,
                        null,null,null, $newFileName);

    return $rs;
}