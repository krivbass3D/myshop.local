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
                VALUE ('{$email}', '{$pwdMD5}', '{$name}', '{$phone}', '{$adress}',)";

    $rs = $mysqli->query($sql);
}