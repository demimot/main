<?php
/*
 * Smarty plugin - DMM
 * -------------------------------------------------------------
 * File:     function.dmm_template_static_content.php
 * Author:   Julio Soares - aug 28th 2015
 * Type:     function
 * Name:     dmm_template_static_content
 * Purpose:  load static content from DB
 * -------------------------------------------------------------
 */
function smarty_function_dmm_template_static_content($params, &$smarty) 
{   
    if ($params['template_name'] and $params['language']){
        $return=array();
        global $dmm_db_connection;
        $query_Recordset1 = "SELECT content_name, content_value FROM static_content WHERE template_name=" . GetSQLValueString($params['template_name'], "text") . " and content_lang=" . GetSQLValueString($params['language'], "text");
        $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
        while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
            $return[$row_Recordset1['content_name']]=$row_Recordset1['content_value'];
        }
    } else {$return = null;}
	
	
	
    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $return);
    } else {
        return $return;
    }
}
?>