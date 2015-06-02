<?php
/*
 * Smarty plugin - DMM
 * -------------------------------------------------------------
 * File:     function.p_tag_this.php
 * Author:   Julio Soares - may 10th 2015
 * Type:     function
 * Name:     p_tag_this
 * Purpose:  trasform line breaks in p tags
 * -------------------------------------------------------------
 */
function smarty_function_p_tag_this($params, &$smarty) 
{   
    if ($params['string']){
		$string = preg_replace_callback('/\n(\s*\n)+/', 'parseTagsRecursive', $params['string']); /* to be used to inject picures and or ads in the body. */
        $string = preg_replace('/\n/', '', $string);
        $string = '<p>'.$string.'</p>';
        $result = $string;
    } else {$result = null;}
	
    if (isset($params['assign'])) {
        $smarty->assign($params['assign'], $result);
    } else {
        return $result;
    }
}

function parseTagsRecursive($input)
{
    global $count_p;
    $regex = '/\n(\s*\n)+/';

    if (is_array($input)) {
        $input = '</hr ></p><!--[$placehold' . $count_p . ']--><p>'.$input[1];
		$count_p++;
    }

    return preg_replace_callback($regex, 'parseTagsRecursive', $input);
}

?>