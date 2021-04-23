<?php

/**
 *
 *Формирование запрашиваемой страницы
 *
 * @param string $controllerName название контроллера
 * @param string $actionName название функции обработки страницы
 *
 */

function loadPage($smarty, $controllerName, $actionName = 'index'){

    include_once PathPrefix . $controllerName . PathPostfix;

    $function = $actionName . 'Action';
    $function($smarty);
}



/**
 * @param object $smarty обїект шаблонизатора
 * @param string $templateName название файла шаблона
 */
function loadTemplate($smarty, $templateName){
    $smarty->dislpay($templateName . TemplatePostfix);
}
