<?php
/*
 * Smarty plugin - DMM
 * -------------------------------------------------------------
 * File:     function.dmm_article_image_handler.php
 * Author:   Julio Soares - may 10th 2015
 * Type:     function
 * Name:     dmm_article_image_handler
 * Purpose:  load article images from DB
 * -------------------------------------------------------------
 */
function smarty_function_dmm_article_image_handler($params, &$smarty) 
{   
    if ($params['article_id']){
        $return=array();
        global $dmm_db_connection;
        $query_Recordset1 = "SELECT article_image_filename, article_image_caption, article_image_credits FROM dmm_article_images WHERE article_id=" . GetSQLValueString($params['article_id'], "int") . " ORDER BY  article_image_weight";
        $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
        while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
            $return[]=$row_Recordset1;
        }
    } else {$return = null;}
	
    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $return);
    } else {
        return $return;
    }
}
?>