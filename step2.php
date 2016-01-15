<?php//--- LAST EDIT: 2016/01/15 ---//?>
<?php
//--- Загрузка главной страницы для сбора информации--------------------------------------------------------------------------------------------------------------------

			if( $curl = curl_init() ) {
				curl_setopt($curl,CURLOPT_URL, $host);
				curl_setopt($curl,CURLOPT_REFERER, $host);
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
				curl_setopt($curl,CURLOPT_AUTOREFERER,true);
				curl_setopt($curl,CURLOPT_RETURNTRANSFER, true); // вывод страницы в переменную
				curl_setopt($curl,CURLOPT_FOLLOWLOCATION, true); //отслеживание заголовка "Location: "
				curl_setopt($curl,CURLOPT_NOBODY,false); //только шапку
				curl_setopt($curl,CURLOPT_TIMEOUT, 30); 
				$data = curl_exec($curl);
				curl_close($curl);
			}

		//Если авторизация не выполнена
		if($data=="" || preg_match('~<a .+class="enter-steam"+>~Uis', $data)){
			$str = "Ошибка: step2.php - Неверный парамитер token'а.";
			_log($str); echo $str;
			_reload("1800*1000", "через 20 минут");
			die();
		}

		//Находим остаток серебра
		preg_match('~<span *class="user__coal"*>(.*)</span>~Uis',$data, $data);
		$cash = $data[1];

//echo "серебра ".$cash;

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------
?>