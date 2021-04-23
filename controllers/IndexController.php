<?php

/**
 * Контроллер главной страницы
 *
 * @param object $smarty шаблонизатор
 */
function testAction () {
    echo 'IndexController.php > testAction';
}

function indexActions($smarty){
    $smarty->assing('pageTitle', 'Главная страница');

    loadTemplate($smarty,'index');
}