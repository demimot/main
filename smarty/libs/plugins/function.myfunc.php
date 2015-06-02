<?php
/*
 * Smarty plugin
 * -------------------------------------------------------------
 * File:     function.myfunc.php
 * Type:     function
 * Name:     myfunc
 * Purpose:  outputs a stupid message
 * -------------------------------------------------------------
 */
function smarty_function_myfunc($params, &$smarty)
{
	if (isset($params['passtext'])) {
		$result = htmlspecialchars($params['passtext']);
	} else {
    	$result = htmlspecialchars('Default');
	}
    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $result);
    } else {
        return $result;
    }


}
?>