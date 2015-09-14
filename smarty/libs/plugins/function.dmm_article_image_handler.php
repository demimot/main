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
        global $dmm_db_connection; //bringing images form issue_article_images not the original fromn article (if some)
        $query_Recordset1 = "SELECT ai.issue_article_image_id, ai.article_image_weight, ai.article_image_filename, ai.article_image_caption, ai.article_image_credits 
                             FROM dmm_issue_article_images ai INNER JOIN dmm_pub_issue_articles pia ON pia.article_id = ai.article_id 
                             WHERE pia.use_article_images AND pia.article_id =" . GetSQLValueString($params['article_id'], "int") . " ORDER BY  article_image_weight";
							 
/* Alternative... what would be faster with many records?

SELECT article_image_id, article_image_weight, article_image_filename, article_image_caption, article_image_credits 
FROM dmm_article_images WHERE article_id =60 AND (SELECT use_article_images FROM dmm_pub_issue_articles WHERE article_id = 60)
ORDER BY  article_image_weight;
*/
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