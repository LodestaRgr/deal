<?php//--- LAST EDIT: 2015/11/15 ---//?>
<?php include("lib/include.php"); //Загрузка функция ?>
<html>
<head><meta http-equiv="Content-Type" Content="text/html; Charset=Windows-1251"></head>
<body>
deal | <a href="set/">set</a> | <a href="log/">log</a>
<hr>
<?php
	if (function_exists('ini_set')){
		ini_set('max_execution_time',18000);
		ini_set('memory_limit', '128M');
		ini_set('date.timezone', 'Europe/Moscow');
	}
//	set_time_limit(18000);

//--- Настройка прокси если необходимо ----------------------------------------------------------------------------------------------------------------------------

//	$proxy = "183.136.135.154:8080";
//	$proxy = explode(':', $proxy);

//--- Подождать перед запуском скрипта от 0 до 5 минут ------------------------------------------------------------------------------------------------------------
/*
		$min=rand(0,4);
		$sec=rand(0,59);

		sleep($min*60+$sec);
*/
//--- параметры -------------------------------------------------------------------

$host = 	'http://gameminer.ru';

		//Загрузка файла с ключами (форимат JSON)
		$keys_file = dirname(__FILE__).'/keys.json';
		$keys = array();

		if (file_exists($keys_file)){
			$json = file_get_contents(dirname(__FILE__).'/keys.json');
			$keys = json_decode($json, true);
		}
/*		else {
			$keys['token'] =	'';
			$keys['_xsrf'] =	'';
			$keys['user_agent'] =	'';
		}
*/
		$ar_topic = Array();
		$j = 0;

// информация о браузере
		if (!isset($keys['user_agent']) || !$keys['user_agent']) $keys['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

//--- Обработка и загрузка в массив раздела - Эвентовые раздачи ---------------------
		$lpage = 	1;
		$mpage =	$lpage;
		$link = 	$host.'/giveaway/event?type=any&q=&enter_price=on&sortby=finish&order=asc&filter_entered=on&filter_mine=on&page=';
	        require 'step1.php';

//--- Обработка и загрузка в массив раздела - Золотые раздачи ---------------------
		$lpage = 	1;
		$mpage =	$lpage;
		$link = 	$host.'/giveaway/golden?type=any&q=&enter_price=on&sortby=finish&order=asc&filter_entered=on&page=';
	        require 'step1.php';

//--- Обработка и загрузка в массив раздела - Обычные раздачи ---------------------

		$lpage = 	1;
		$mpage =	$lpage;
		$link = 	$host.'/giveaway/coal?type=any&q=&enter_price=on&sortby=finish&order=asc&filter_entered=on&page=';
	        require 'step1.php';

//--- Обработка и загрузка в массив раздела - Песочница ---------------------------

		$lpage = 	1;
		$mpage =	$lpage;
		$link = 	$host.'/giveaway/sandbox?type=any&q=&enter_price=on&sortby=finish&order=asc&filter_entered=on&page=';
	        require 'step1.php';

//---------------------------------------------------------------------------------

//print_r($ar_topic);

//--- Просчет наиболее выгодных раздач --------------------------------------------

	        require 'step2.php';

//--- Запросы на участие в раздачах -----------------------------------------------

	        require 'step3.php';

//--- Вывод лога на экран ---------------------------------------------------------

?><textarea id="log" name="txtArea" cols="80" rows="25" style="width:100%;height:90%;"><?=file_get_contents(dirname(__FILE__)."/log.txt");?></textarea><?php

	_reload();

//--- Функции ----------------------------------------------------------------------------------------------------------------------------------------------------------
?>
</script></body></html>