<?php

$_lang['comparison_prop_id'] = 'Id товара для добавления в список. По умолчанию - текущий ресурс.';
$_lang['comparison_prop_tpl'] = 'Чанк добавления к списку сравнения.';
$_lang['comparison_prop_tpl_get'] = 'Чанк оформления ссылки на сравнение.';
$_lang['comparison_prop_list_get'] = 'Имя существующего списка сравнения.';
$_lang['comparison_prop_list'] = 'Произвольное имя списка сравнения. Если у вас товары разных типов - указывайте для них разные имена списков. Указанное имя обязательно должно быть в массиве "&fields" сниппета "CompareList".';
$_lang['comparison_prop_list_id'] = 'Обязательный параметр с указанием id страницы, на которой вызван сниппет "ComparisonList".';
$_lang['comparison_prop_minItems'] = 'Минимальное количество товаров для сравнения.';
$_lang['comparison_prop_maxItems'] = 'Максимальное количество товаров для сравнения.';

$_lang['comparison_prop_fields'] = 'JSON строка с именами списков сравнения и массивом сравниваемы полей. Например: {"test":["price","weight"]}. Опции товаров и поля производителя указыаются с префиксами: {"test":["vendor.name","option.color","option.test"]}.';
$_lang['comparison_prop_tplRow'] = 'Чанк с одной строкой таблицы сравнения товаров. Плейсхолдеры [[+cells]] и [[+same]].';
$_lang['comparison_prop_tplParam'] = 'Чанк с именем параметра товара. Плейсхолдеры [[+param]] и [[+row_idx]].';
$_lang['comparison_prop_tplCell'] = 'Ячейка таблицы сравнения с одним значением параметра товара. Плейсхолдеры [[+value]], [[+classes]] и [[+cell_idx]].';
$_lang['comparison_prop_tplHead'] = 'Ячейка заголовка товара в таблице сравнения. Здесь можно использовать все плейсхолдеры товара.';
$_lang['comparison_prop_tplCorner'] = 'Угловая ячейка таблицы, со ссылками на переключение параметров сравнения. Плейсхолдеров нет.';
$_lang['comparison_prop_tplOuter'] = 'Чанк-обёртка таблицы сравнения. Плейсхолдеры [[+head]] и [[+rows]].';
$_lang['comparison_prop_formatSnippet'] = 'Произвольный сниппет для оформления значения параметра товара. Получает имя поля "$field" и его значение "$value". Должен вернуть отформатированную строку "$value".';
$_lang['comparison_prop_showLog'] = 'Вывести администратору подробный лог работы сниппета.';