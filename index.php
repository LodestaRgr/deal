<?php//--- LAST EDIT: 2015/11/15 ---//?>
<?php include("lib/include.php"); //�������� ������� ?>
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

//--- ��������� ������ ���� ���������� ----------------------------------------------------------------------------------------------------------------------------

//	$proxy = "183.136.135.154:8080";
//	$proxy = explode(':', $proxy);

//--- ��������� ����� �������� ������� �� 0 �� 5 ����� ------------------------------------------------------------------------------------------------------------
/*
		$min=rand(0,4);
		$sec=rand(0,59);

		sleep($min*60+$sec);
*/
//--- ��������� -------------------------------------------------------------------

$host = 	'http://gameminer.ru';

		//�������� ����� � ������� (������� JSON)
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

// ���������� � ��������
		if (!isset($keys['user_agent']) || !$keys['user_agent']) $keys['user_agent'] = $_SERVER['HTTP_USER_AGENT'];

//--- ��������� � �������� � ������ ������� - ��������� ������� ---------------------
		$lpage = 	1;
		$mpage =	$lpage;
		$link = 	$host.'/giveaway/event?type=any&q=&enter_price=on&sortby=finish&order=asc&filter_entered=on&filter_mine=on&page=';
	        require 'step1.php';

//--- ��������� � �������� � ������ ������� - ������� ������� ---------------------
		$lpage = 	1;
		$mpage =	$lpage;
		$link = 	$host.'/giveaway/golden?type=any&q=&enter_price=on&sortby=finish&order=asc&filter_entered=on&page=';
	        require 'step1.php';

//--- ��������� � �������� � ������ ������� - ������� ������� ---------------------

		$lpage = 	1;
		$mpage =	$lpage;
		$link = 	$host.'/giveaway/coal?type=any&q=&enter_price=on&sortby=finish&order=asc&filter_entered=on&page=';
	        require 'step1.php';

//--- ��������� � �������� � ������ ������� - ��������� ---------------------------

		$lpage = 	1;
		$mpage =	$lpage;
		$link = 	$host.'/giveaway/sandbox?type=any&q=&enter_price=on&sortby=finish&order=asc&filter_entered=on&page=';
	        require 'step1.php';

//---------------------------------------------------------------------------------

//print_r($ar_topic);

//--- ������� �������� �������� ������ --------------------------------------------

	        require 'step2.php';

//--- ������� �� ������� � �������� -----------------------------------------------

	        require 'step3.php';

//--- ����� ���� �� ����� ---------------------------------------------------------

?><textarea id="log" name="txtArea" cols="80" rows="25" style="width:100%;height:90%;"><?=file_get_contents(dirname(__FILE__)."/log.txt");?></textarea><?php

	_reload();

//--- ������� ----------------------------------------------------------------------------------------------------------------------------------------------------------
?>
</script></body></html>