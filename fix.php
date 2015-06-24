<?php /*
require('Connections/dmm_db_connection.php');
$query_Recordset1 = "update dmm_pubs set pub_mote = 'Uma outra revista para você.' WHERE pub_id=2";
mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
*/
require($_SERVER["DOCUMENT_ROOT"] . '/config/dmm_config.php');
echo toAscii('Demi Mot Revista')."<br />";
echo toAscii('Revista Teste')."<br />";
echo toAscii('Revista da Mulher')."<br />";
echo toAscii('Nova era')."<br />";
echo toAscii('Admin')."<br />";


?>