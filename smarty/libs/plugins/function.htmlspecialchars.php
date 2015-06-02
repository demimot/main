<?php
/*
 * Smarty plugin - DMM
 * -------------------------------------------------------------
 * File:     function.langswitch.php
 * Author: Julio Soares - april 28th 2015
 * Type:     function
 * Name:     langswitch
 * Purpose:  Sets languages url parameters for language flags
 * -------------------------------------------------------------
 */
function smarty_function_langswitch($params, &$smarty)
{
	if (isset($params['assign'])){
        if ($params['lang'] == "en"){
            $result = array("lang1" => "pt", "lang2" => "fr", "flag1" => "br.png", "flag2" => "fr.png", "language1" => "French", "language2" => "Portuguese");
	    } elseif ($params['lang'] == "fr") {
	        $result = array("lang1" => "en", "lang2" => "pt", "flag1" => "gb.png", "flag2" => "br.png", "language1" => "Anglais", "language2" => "Portugais");
	    } elseif ($params['lang'] == "pt") {
	        $result = array("lang1" => "en", "lang2" => "fr", "flag1" => "gb.png", "flag2" => "fr.png", "language1" => "Inglês", "language2" => "Francês");
        } else {$result = null;}
	}
    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $result);
    } else {
        return "Error - you must define an 'assign' paramater";
    }

}
?>