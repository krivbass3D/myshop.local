<?php


function getChildrenForCat($catid){
    include '../config/db.php'; // инициализация БД

    $sql = "SELECT *
        FROM categories
        WHERE 
        parent_id = '{$catid}'";

    $rs = $mysqli->query($sql);

    return createSmartyRsArray($rs);
}


/**
 *
 * Модель для таблицы категорий
 *
 * @return array массив категорий
 */
function getAllMainCatsWithChildren(){

    include '../config/db.php'; // инициализация БД

    //$mysqli = new mysqli(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

    $sql = 'SELECT *
        FROM categories
        WHERE parent_id = 0';

    $rs = $mysqli->query($sql);
    $smartyRs = array();
    while ($row = $rs->fetch_array(MYSQLI_ASSOC)){
        $rsChildren = getChildrenForCat($row['id']);
        if($rsChildren){
            $row['children'] = $rsChildren;
        }
        $smartyRs [] = $row;
    }

    return $smartyRs;
}


/**
 * Получить данную категорию по id
 *
 * @param integer $catId
 */
function getCatById($catId)
{
    include '../config/db.php'; // инициализация БД
    $catId = intval($catId);

    $sql = "SELECT *
                FROM categories
                WHERE 
                id = '{$catId}'";

    $rs = $mysqli->query($sql);

    return $rs->fetch_assoc();
}