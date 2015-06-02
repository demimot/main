<?php

 
if ($_SERVER['REQUEST_METHOD'] == 'POST')
{
    $this_username=GetSQLValueString($_POST['frm_username'], "text");
    $this_password=GetSQLValueString(sha1("tamarindo" . $_POST['frm_password']), "text");

    mysql_select_db($database_dmm_db_connection, $dmm_db_connection);
    $query_Recordset1 = "SELECT * FROM dmm_users WHERE dmm_users.user_username=" . $this_username . " AND dmm_users.user_pwd=" . $this_password ;
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    $row_Recordset1 = mysql_fetch_assoc($Recordset1);
	
	
}
else
{
	header("Location: http://www.demimot.com"); /* Redirect browser */
    exit();
}

mysql_free_result($Recordset1);
?>