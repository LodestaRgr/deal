<?php//--- LAST EDIT: 2016/01/15 ---//?>
<?php

//		$ar_topic = Array();
//		$j=0;

//��������� ������ ������� ---------------------------------------------------------------------------------------------------------------------------------------------

		while($lpage <= $mpage){

//--- ��������� ����� ��������� ������� �� 0.5 �� 3 ������ ------------------------------------------------------------------------------------------------------------

		sleep(rand(50,300)/100);

//----------------------------------------------------------------------------------------------------------------------------------------------------------------------

			if( $curl = curl_init() ) {
				curl_setopt($curl,CURLOPT_URL, $link.$lpage);
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
				curl_setopt($curl,CURLOPT_RETURNTRANSFER, true); // ����� �������� � ����������
				curl_setopt($curl,CURLOPT_FOLLOWLOCATION, true); //������������ ��������� "Location: "
				curl_setopt($curl,CURLOPT_NOBODY,false); //������ �����
				curl_setopt($curl,CURLOPT_TIMEOUT, 30); 
				$data = curl_exec($curl);
				curl_close($curl);
			}
//echo $data;
//die();
			//���� ����������� �� ���������
			if($data=="" || preg_match('~<a .+class="enter-steam"+>~Uis', $data)){
				$str =	"������: step1.php - �������� ��������� token'�.";
				_log($str); echo $str.
				"<br>�������� ���������� �������� ����� <a href=\"set/\">��� set</a>.";
				_reload("900*1000", "����� 10 �����");
				die();
			}

			//����� ���������� �������
			preg_match('~<div *class="[^m]*m-pagination-title*"*>[^<ul]*<ul>(.*)</ul>[^</div]*</div>~Uis',$data , $data2);
			$data2 = preg_replace("~<a href[^>]*>~Uis","",$data2); //������� ������
			$data2 = preg_replace("~</a>~Uis","",$data2); //������� ������

			//���� ������ ������� �� ������, ������ 1-� �������� )))
			if (count($data2)<2) $data2 = Array("","<li>1</li>");

			//�������� ������ ������� �������
			preg_match_all('~<li[^<>]*>([0-9]+)</li[^>]*>~si',$data2[1] , $ar_page); 
//print_r($ar_page);
			$mpage = max($ar_page[1]);

			if($lpage<=max($ar_page[1])){
//echo "[$lpage]\n";
//--- ��������� ������ �� ������� �������� -----------------------------------------------------------------------------------------------------------------------------
//				preg_match('~<div *class="giveaways__page clearfix"*>(.*)[^</div]*</div>[^<div]*<div *class="giveaways__paging clearfix"*>~Uis',$data , $data2);
				preg_match_all('~<div *class="giveaway__container"*>(.*)[^<div]*<div *class="giveaway-error__text"*></div>~Uis',$data , $ar_container); //�������� ������ �������
				$ar_container = $ar_container[1]; //���������� ������� ������� �������� � �������
                
				if(count($ar_container)>0){
					for($i=0; $i<count($ar_container); $i++){
					//��������� ����������� � ���� ������� ������� ��������
                
							preg_match('~<div *class="giveaway__action"*>(.*)</div>~Uis',$ar_container[$i], $ar_str);
							if(isset($ar_str[1]))
							preg_match('~<form .*action="(.*)".*>~Uis',$ar_str[1], $ar_str);
							if(isset($ar_str[1]))
						//�������� ������ ��� �������
						$ar_topic[$j]['action'] = $ar_str[1];
					//��������� ���� �� ������ ��� �������,
					//���� ���� �� � ������ ������ ���� ��������� � ���� �������
					if(isset($ar_topic[$j]['action'])){
							preg_match('~<div *class="giveaway__topc"*>(.*)</div>~Uis',$ar_container[$i], $ar_str);
						//�������� ID-������ ������
						$ar_topic[$j]['id'] = preg_replace('~<a .*href="(.*)".*>.*</a>~Uis','\\1',$ar_str[1]);
						//�������� ��� ������
						$ar_topic[$j]['name'] = preg_replace('~<a [^>]+>([^<]+)</a*>~Uis','\\1',$ar_str[1]);
                
							$ar_container[$i] = preg_replace('~<span *class="giveaway__timeleft-text"*>(.*)</span>~Uis','',$ar_container[$i]); //������� ����� ��������
							preg_match('~<span *class="giveaway__timeleft"*>(.*)</span>~Uis',$ar_container[$i], $ar_str);

							//������������� ��������� ����� � ��������� �����
							if(isset($ar_str[1])){

								$timeleft = 0;
								preg_match('~([0-9]+) (month|months)~is',$ar_str[1], $out);
								if(isset($out[1])) $timeleft = $timeleft + ($out[1]*44640);

								preg_match('~([0-9]+) (day|days)~is',$ar_str[1], $out);
								if(isset($out[1])) $timeleft = $timeleft + ($out[1]*1440);

								preg_match('~([0-9]+) (hour|hours)~is',$ar_str[1], $out);
								if(isset($out[1])) $timeleft = $timeleft + ($out[1]*60);

								preg_match('~([0-9]+) (minute|minutes)~is',$ar_str[1], $out);
								if(isset($out[1])) $timeleft = $timeleft + ($out[1]);

								$ar_str[1] = $timeleft;
							}
						//�������� ���������� �����
						$ar_topic[$j]['timeleft'] = $ar_str[1];//less than a minute - (������ ������)

							preg_match('~Entries:.*<span[^>]+>(.*)</span>~Uis',$ar_container[$i], $ar_str);
						//�������� ���������� ����������
						$ar_topic[$j]['entries'] = $ar_str[1];

							preg_match('~Entrance fee:.*<span[^>]+>(.*)</span>~Uis',$ar_container[$i], $ar_str);
							$ar_str[1] = preg_replace("~ coal~is","",$ar_str[1]); //������� (����� �������)
						//�������� ����� �������
						$ar_topic[$j]['price'] = $ar_str[1];
						$j++;
					}
					}
				}
//----------------------------------------------------------------------------------------------------------------------------------------------------------------------
			}
			$lpage++;
		}
?>