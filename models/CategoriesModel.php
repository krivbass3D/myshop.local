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


/**
 * Получить все главные категории которые не дочерние
 *
 * @return array массив категорий
 */
function getAllMainCategories()
{
    include '../config/db.php'; // инициализация БД
    $sql = 'SELECT *
                FROM categories
                WHERE parent_id = 0';
    $rs = $mysqli->query($sql);

    return createSmartyRsArray($rs);
}

function insertCat($catName, $catParentId = 0)
{
    include '../config/db.php'; // инициализация БД
    $sql = "INSERT INTO
                categories (`parent_id`,`name`)
            VALUE ('{$catParentId}', '{$catName}')";

    $rs = $mysqli->query($sql);

    return $mysqli->insert_id;
}

/**
 * Получить все категории которые не дочерние
 *
 * @return array массив категорий
 */
function getAllCategories()
{
    include '../config/db.php'; // инициализация БД
    $sql = 'SELECT *
                FROM categories
                ORDER BY parent_id ASC';
    $rs = $mysqli->query($sql);

    return createSmartyRsArray($rs);
}

function updateCategoryData($itemId, $parentId = -1, $newName = " ")
{

    include '../config/db.php'; // инициализация БД
    $set = array();

    if ($newName){
        $set[] = "`name` = '{$newName}'";
    }

    if ($parentId){
        $set[] = "`parent_id` = '{$parentId}'";
    }

    $setStr = implode(", ", $set );
    $sql = " UPDATE categories
                SET {$setStr}
                WHERE id = '{$itemId}'";

    $rs = $mysqli->query($sql);

    return $rs;
}