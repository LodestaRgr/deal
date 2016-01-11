<?php//--- LAST EDIT: 2015/11/14 ---//?>
<?php include("../lib/include.php"); //Загрузка функция ?>
<html>
<head>
<meta http-equiv="Content-Type" Content="text/html; Charset=Windows-1251">
<SCRIPT language="javascript" type="text/javascript" src="../lib/jquery.js"></SCRIPT>
</head>
<body>
<a href="../">deal</a> | set | <a href="../log/">log</a>
<hr>
Вставьте сюда шапку (header) страницы с gameminer.ru:<BR>
<textarea name="reply" id="reply" cols="140" rows="10" onkeyup="return SetInfo(event)">
</textarea>
<BR>
<input type="button" value="Проверить" id="gen" onmousedown="return SetInfo(event)"/>
<input type="button" value="Отправить в программу" id="send" style="font-weight: bold;"/>
<BR>
<div id="send_complete"></div>
<HR>
<pre><div id="key_xsrf"> </div><div id="key_token"> </div><div id="key_user_agent"> </div></pre>

<form id="my_form" action="javascript: null;">
<input type="button" value="Ручной ввод" onmousedown="javascript: $('#manual').show();"/>
<div id="manual" style="display:none;"><pre><b>
_xsrf =		<input type="text" size="35" value="" name="_xsrf"/>
token =		<input type="text" size="35"  value="" name="token"/>
Use-Agent =	<input type="text" size="160" value="" name="user_agent"/>
</b></pre></div>
</form>

<script>
function SetInfo(e) {

    var txt = '';
	txt = document.getElementById('reply').value

	$('#send_complete').html("");

	//ишет ключ '_xsrf' из текска Header
	key_xsrf = txt.match(/_xsrf=([0-9a-zA-Z]+);/);
	if (key_xsrf === null) key_xsrf = ''; else key_xsrf = key_xsrf[1];
	$('#key_xsrf').html("<B>_xsrf</B> =		" + key_xsrf);
	$("input[name='_xsrf']").val(key_xsrf);

	//ишет ключ 'token' из текска Header
	key_token = txt.match(/token=([0-9a-zA-Z]+);/);
	if (key_token === null) key_token = ''; else key_token = key_token[1];
	$('#key_token').html("<B>token</B> =		" + key_token);
	$("input[name='token']").val(key_token);

	//ишет ключ 'User-Agent' из текска Header
	key_user_agent = txt.match(/User-Agent:(.*)/);
	if (key_user_agent === null) key_user_agent = ''; else key_user_agent = key_user_agent[1];
	$('#key_user_agent').html("<B>User-Agent</B> =	" + key_user_agent);
	$("input[name='user_agent']").val(key_user_agent);
}

$("#send").live('click', function()
{
	if (	//Если один из ключей пуст - тогда не отправляем
		$("input[name='_xsrf']").val() == '' ||
		$("input[name='token']").val() == '' ||
		$("input[name='user_agent']").val() == ''
	)	$('#send_complete').html("<font color=red><B>Необходимо найти ВСЕ ключи !!!</B></font>");
	else
	{	//Если все ключи найдены - тогда отправляем
		$.ajax({
			type: "POST",
			url: 'set.php',
			data: $('#my_form').serialize(),
			dataType: "json",
			cache: false,
			error: function(msg){
				alert('error! IE browser');
			},
			success: function(res)
			{
				$('#send_complete').html("<B>ОТПРАВЛЕНО !!!</B>");
			}
		});
	}
});
</script><BR>
<?

		//Загрузка файла с ключами (форимат JSON)
		$keys_file = dirname(__FILE__).'/../keys.json';
		$keys = array();

		if (file_exists($keys_file)){
			$json = file_get_contents(dirname(__FILE__).'/../keys.json');
			$keys = json_decode($json, true);
		}
/*		else {
			$keys['token'] =	'';
			$keys['_xsrf'] =	'';
			$keys['user_agent'] =	'';
		}
*/
?>
<B>Текущие настройки:</B>
<div><pre><b>
_xsrf =		<?php echo $keys['_xsrf'];?> 
token =		<?php echo $keys['token'];?> 
Use-Agent =	<?php echo $keys['user_agent'];?> 
</b></pre></div>
</body>
</html>