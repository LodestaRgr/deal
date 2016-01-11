<?php//--- LAST EDIT: 2015/11/14 ---//?>
<?php include("../lib/include.php"); //Загрузка функция ?>
<?php
// check if a form was submitted
if( !empty( $_POST ) ){
// convert form data to json format
$json = json_encode( $_POST );
// make sure there were no problems
//if( json_last_error() != JSON_ERROR_NONE ){
    //exit;  // do your error handling here instead of exiting
// }
$file = dirname(__FILE__).'/../keys.json';
// write to file
//   note: _server_ path, NOT "web address (url)"!
file_put_contents( $file, $json);
}
?>