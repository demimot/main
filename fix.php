<?php require('Connections/dmm_db_connection.php');
$query_Recordset1 = "update dmm_pubs set pub_mote = 'Uma outra revista para você.' WHERE pub_id=2";
mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());

?>