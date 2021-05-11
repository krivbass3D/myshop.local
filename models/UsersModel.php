<?php
/**
 * Модель таблицы пользователей
 *
 */

function registerNewUser ($email, $pwdMD5, $name, $phone, $adress)
{
    include '../config/db.php'; // инициализация БД
    $email  = htmlspecialchars($mysqli->real_escape_string($email));
    $name  = htmlspecialchars($mysqli->real_escape_string($name));
    $phone  = htmlspecialchars($mysqli->real_escape_string($phone));
    $adress  = htmlspecialchars($mysqli->real_escape_string($adress));

    $sql = "INSERT INTO
                users (`email`, `pwd`, `name`, `phone`, `adress`)
                VALUE ('{$email}', '{$pwdMD5}', '{$name}', '{$phone}', '{$adress}')";

    $rs = $mysqli->query($sql);

    if($rs){
        $sql = "SELECT * FROM users
                    WHERE (`email` = '{$email}' and `pwd` = '{$pwdMD5}')
                    LIMIT 1";
        $rs = $mysqli->query($sql);

        $rs = createSmartyRsArray($rs);

        if(isset($rs[0])){
            $rs['success'] = 1;
        }else{
            $rs['success'] = 0;
        }
    } else {
        $rs['success'] = 0;
    }

    return $rs;
}

function checkRegisterParams ($email, $pwd1, $pwd2){

    $res = null;
    if (!$email){
        $res['success'] = false;
        $res['message'] = 'Введите email';
    }

    if (!$pwd1){

        $res['success'] = false;
        $res['message'] = 'Введите пароль';
    }

    if (!$pwd2){
        $res['success'] = false;
        $res['message'] = 'Введите повтороно пароль';
    }

    if ($pwd1 !=$pwd2){
        $res['success'] = false;
        $res['message'] = 'Пароль не совпадает';
    }

    return $res;
}

function checkUserEmail($email){
    include '../config/db.php'; // инициализация БД
    $email = $mysqli->real_escape_string($email);
    $sql = "SELECT id FROM users WHERE email = '{$email}'";

    $rs = $mysqli->query($sql);
    $rs = createSmartyRsArray($rs);

    return $rs;
}

function loginUser($email, $pwd){

    include '../config/db.php'; // инициализация БД
    $email = htmlspecialchars($mysqli->real_escape_string($email));
    $pwd = md5($pwd);

    $sql = "SELECT * FROM users
            WHERE (`email` = '{$email}' and `pwd` = '{$pwd}')
            LIMIT 1";

    $rs = $mysqli->query($sql);
    $rs = createSmartyRsArray($rs);
    if (isset($rs[0])){
        $rs['success'] = 1;
    }else{
        $rs['success'] = 0;
    }

    return $rs;
}

/**
 * Изменение данных пользователя
 *
 * @param string $name имя пользователя
 * @param string $adress
 * @param string $pwd1
 * @param string $pwd2
 * @param string$curPwd
 * @return boolean TRUE в случае успеха
 */
function updateUserData($name, $phone, $adress, $pwd1, $pwd2, $curPwd)
{
    include '../config/db.php'; // инициализация БД

    $email = htmlspecialchars($mysqli->real_escape_string($_SESSION['user']['email']));
    $name = htmlspecialchars($mysqli->real_escape_string($name));
    $phone = htmlspecialchars($mysqli->real_escape_string($phone));
    $adress = htmlspecialchars($mysqli->real_escape_string($adress));
    $pwd1 = trim($pwd1);
    $pwd2 = trim($pwd2);

    $newPwd = null;
    if ($pwd1 && ($pwd1==$pwd2)){
        $newPwd = md5($pwd1);
    }

    $sql = "UPDATE users
            SET ";

    if ($newPwd){
        $sql .= "`pwd` = '{$newPwd}', ";
    }

    $sql .= " `name` = '{$name}',
              `phone` = '{$phone}',
              `adress` = '{$adress}'
            WHERE 
                `email` = '{$email}' AND `pwd` = '{$curPwd}'
            LIMIT 1";

    $rs = $mysqli->query($sql);

    return $rs;
}