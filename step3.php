<?php//--- LAST EDIT: 2016/01/15 ---//?>
<?php
	for($i=0;$i<count($ar_topic);$i++){
		//Если стоимость топика 0 серебра
		//или стоимость топика 1 и серебра больше 0
		if(($ar_topic[$i]['price'] == 0) || ($ar_topic[$i]['price'] == 1 && $cash > 0)){
//		if(($ar_topic[$i]['price'] == 0)){

//--- Подождать перед отправной запроса от 3 до 10 секунд ------------------------------------------------------------------------------------------------------------

		sleep(rand(300,1000)/100);

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------

			if( $curl = curl_init() ) {
				curl_setopt($curl,CURLOPT_URL, $host.$ar_topic[$i]['action']);
//				curl_setopt($curl,CURLOPT_REFERER, $host);
				curl_setopt($curl,CURLOPT_POST, true);
				curl_setopt($curl,CURLOPT_POSTFIELDS, "_xsrf=".$keys['_xsrf']."&json=true");
				if (isset($proxy)){
					curl_setopt($curl,CURLOPT_PROXY, $proxy[0]);
					curl_setopt($curl,CURLOPT_PROXYPORT, $proxy[1]);
				}
				curl_setopt($curl,CURLOPT_HTTPHEADER, array(
						"Cache-Control:max-age=0",
						"User-Agent: ".$keys['user_agent']
				));
				curl_setopt($curl,CURLOPT_COOKIE, "lang=en_US;token=".$keys['token']."; _xsrf=".$keys['_xsrf'].";");
				curl_setopt($curl,CURLOPT_HEADER,false);
//				curl_setopt($curl,CURLOPT_AUTOREFERER,true);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER, true); // вывод страницы в переменную
				curl_setopt($curl,CURLOPT_FOLLOWLOCATION, true); //отслеживание заголовка "Location: "
				curl_setopt($curl,CURLOPT_NOBODY,false); //только шапку
				curl_setopt($curl,CURLOPT_TIMEOUT, 30); 
				$data = curl_exec($curl);
				curl_close($curl);
			}

//echo $data;
//die();
//<span class="user__coal">

			//Если авторизация не выполнена
			if($data==""){
				$str = "Ошибка: step3.php - Возможно неверный парамитер token'а.";
				_log($str); echo $str;
				_reload("900*1000", "через 10 минут");
				die();
			}

//$data = '{"status": "ok", "coal": 12, "gold": 0}';

			//Загрузка информации в массив
			$data = json_decode($data, true);

			//Проверка на ошибку
			if(isset($data['error'])){
				_log("Ошибка : ".substr_replace("                                                        ", $data['error']['message'], 0, strlen($data['error']['message']))."	Стоим.:	".$ar_topic[$i]['price']."	".$ar_topic[$i]['name']);
			}else

			//Если все хорошо
			if(isset($data['status']) && $data['status'] == 'ok'){
				$cash = $data['coal'];

				$tl = $ar_topic[$i]['timeleft'];
				$tl_ar['d'] = 0;
				$tl_ar['h'] = 0;
				$tl_ar['m'] = 0;

				$tl_ar['d'] = floor($tl/1440);
				$tl_ar['h'] = floor(($tl-($tl_ar['d']*1440))/60);
				$tl_ar['m'] = floor($tl-($tl_ar['d']*1440)-($tl_ar['h']*60));

				$tl_str = "";
				if($tl_ar['d']) $tl_str.=substr_replace("   ", $tl_ar['d'], 3-strlen($tl_ar['d']))."d ";else $tl_str.="     ";
				if($tl_ar['h']) $tl_str.=substr_replace("   ", $tl_ar['h'], 3-strlen($tl_ar['h']))."h ";else $tl_str.="     ";
				if($tl_ar['m']) $tl_str.=substr_replace("   ", $tl_ar['m'], 3-strlen($tl_ar['m']))."m ";else $tl_str.="     ";

				_log("Успешно! Серебра 	".$cash."	Ставка:	".($ar_topic[$i]['entries']+1)."	Через:	".$tl_str."	Стоим.:	".$ar_topic[$i]['price']."	".$ar_topic[$i]['name']);
			}

		}
	}
?>