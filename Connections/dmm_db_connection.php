<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
require_once("dmm-db-info.php");
$dmm_db_connection = mysql_pconnect($hostname_dmm_db_connection, $username_dmm_db_connection, $password_dmm_db_connection) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_dmm_db_connection, $dmm_db_connection); 
?>