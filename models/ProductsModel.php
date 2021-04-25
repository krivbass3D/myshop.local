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