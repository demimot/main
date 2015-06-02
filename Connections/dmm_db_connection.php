<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_dmm_db_connection = "fdan.myd.infomaniak.com";
$database_dmm_db_connection = "fdan_demimotcom";
$username_dmm_db_connection = "fdan_dmmuser";
$password_dmm_db_connection = "sw50z4zwQEvegIpb";
$dmm_db_connection = mysql_pconnect($hostname_dmm_db_connection, $username_dmm_db_connection, $password_dmm_db_connection) or trigger_error(mysql_error(),E_USER_ERROR);
mysql_select_db($database_dmm_db_connection, $dmm_db_connection); 
?>