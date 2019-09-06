<?php
//проверка вызывается ли скрипт из ядра или напрямую
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true)die();

//подключение файлов локализации
//D7 - более универсальный и удобный https://dev.1c-bitrix.ru/api_d7/bitrix/main/localization/loc/loadmessages.php
use Bitrix\Main\Localization\Loc;
Loc::loadMessages(__FILE__);
//Старое ядро
IncludeModuleLangFile(__FILE__);
//или
IncludeTemplateLangFile(__FILE__)
//у компонентов тоже свой метод есть

//получение названия месяца в двух падежах(в языковом файле):
echo $MESS['MONTH_'.date('n')]; // Июнь
echo $MESS['MONTH_'.date('n').'_S']; // Июня


//Перед использованием модуля необходимо проверить установлен ли он и подключить его при помощи конструкции
//для D7
use Bitrix\Main\Loader;
if (Loader::includeModule('ID модуля')) {
    // здесь можно использовать функции и классы модуля
}
//для старого ядра
// подключаем модуль mymodule
if (CModule::IncludeModule("mymodule"))
{
    // выполним его метод
    CMyModuleClass::DoIt();
}

//чтобы init.php не превращался в свалку лучше подключать к нему файлы (желательно через __autoload)
CModule::AddAutoloadClasses(
        '', // не указываем имя модуля
        array(
           // ключ - имя класса, значение - путь относительно корня сайта к файлу с классом
                'CMyClassName1' => '/path/cmyclassname1file.php',
                'CMyClassName2' => '/path/cmyclassname2file.php',
        )
);

//установка параметра false позволяет ограничить выборку только преобразованными значениями полей
$rs = CIBlockResult::GetNext(true, false);


//количество элементов в выборке: если указать в параметре группировки пустой массив то получим искомое
//https://alittlebit.ru/blog/vebmasterskaya/1c-bitrix/kolichestvo-elementov.html
//https://dev.1c-bitrix.ru/api_help/iblock/classes/ciblockelement/getlist.php
$count = CIBlockElement::GetList(Array(), $arFilter, Array(), false, Array());
//или используем метод SelectedRowsCount уже после getlist
$elements = CIBlockElement::GetList(array(), $arFilter, false, false, $arSelect);
$arResult["CNT"] = $elements->SelectedRowsCount();

for ($i=0; $i < ; $i++) { 
	# code...
}

//обращение к глобальным переменным плохая практика?..
//используем
$request = \Bitrix\Main\Application::getInstance()->getContext()->getRequest();
$request->get('name')
//или
$request['name'];


//отложенный вывод
//в коде выше где нужно вывести что-то
$APPLICATION->ShowViewContent('complaint');
//в коде ниже
ob_start();
echo "Ваше мнение учтено, №{$productId}";
$APPLICATION->AddViewContent('complaint', ob_get_clean());
//в шаблоне компонентов используется такая конструкция
$this->SetViewTarget("complaint");
echo "Ваше мнение учтено, №{$productId}";
$this->EndViewTarget();