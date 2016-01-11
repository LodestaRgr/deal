<?php//--- LAST EDIT: 2014/10/12 ---//?>
<html>
<head><meta http-equiv="Content-Type" Content="text/html; Charset=Windows-1251"></head>
<body>
<a href="../">deal</a> | <a href="../set/">set</a> | log
<hr>
<pre>
<?php
//echo iconv("CP1251", "UTF-8",file_get_contents(dirname(__FILE__)."/../log.txt" ));
echo file_get_contents(dirname(__FILE__)."/../log.txt" );
?>
</pre>
</body>
</html>