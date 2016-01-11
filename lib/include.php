<?php//--- LAST EDIT: 2015/11/15 ---//?>
<?php

//-- Если функции JSON не обнаружены ------ 
if (!function_exists('json_encode')) {
	include(dirname(__FILE__)."/JSON.php");
	function json_encode($data) {
        $json = new Services_JSON();
        return($json->encode($data));
	}
    function json_decode($data, $bool) {
        if ($bool) {
            $json = new Services_JSON(SERVICES_JSON_LOOSE_TYPE);
        } else {
            $json = new Services_JSON();
        }
        return( $json->decode($data) );
    }
} 

//-- Запись в лог файл -------------------- 
if (!function_exists('_log')) {
function _log($string){

	$flog = dirname(__FILE__).'/../log.txt';

	$flines = Array();
	if(file_exists($flog))
		$flines = file($flog);
	$flines = array_reverse($flines);
	$flines[] = date('Y-m-d H:i:s > ',time()).$string."\n";
	$flines = array_reverse($flines);

	$fp = fopen ($flog, "w");
	for($i=0;$i<count($flines);$i++){
		if($i==2000) $i=count($flines);	//Количество отображаемых строк
		else fwrite($fp, $flines[$i]);
	}
	fclose($fp);
}
}


//----------------------------------------- 
if (!function_exists('_reload')) {
function _reload($_second="randomNumber(600,1800)*1000", $_desc="в диапазоне от 10 до 30 минут"){
?>
<div id='div'></div>
<script type="text/javascript">
document.getElementById('div').innerHTML = '<B>Скрипт перезагружается <?php echo $_desc;?>.</B>'
setTimeout(function () {document.location.href = ''},(<?php echo $_second;?>));

function randomNumber (m,n)
{
m = parseInt(m);
n = parseInt(n);
return Math.floor( Math.random() * (n - m + 1) ) + m;
}
</script><?php
}}

//----------------------------------------- 

?>