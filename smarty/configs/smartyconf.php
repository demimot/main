<?php 

$smarty->setTemplateDir($_SERVER["DOCUMENT_ROOT"] . '/smarty/templates');
$smarty->setCompileDir($_SERVER["DOCUMENT_ROOT"] . '/smarty/templates_c');
$smarty->setCacheDir($_SERVER["DOCUMENT_ROOT"] . '/smarty/cache');
$smarty->setConfigDir($_SERVER["DOCUMENT_ROOT"] . '/smarty/configs');

## Change templates delimiters
$smarty->left_delimiter = '<!--[';
$smarty->right_delimiter = ']-->';

##Setup cahing
$smarty->caching = 1;
$smarty->compile_check = 1;
$smarty->force_compile = 1; ## Coment after development
$request_use_auto_globals = 1;


## HTMLize all variable content
## $smarty->registerFilter('variable', 'htmlspecialchars'); /* does not work. Produces an error: Warning: htmlspecialchars() expects parameter 2 to be long, object given in /home/www/eedb4859e9b8c8ef2cff23da687f9d34/web/smarty/libs/sysplugins/smarty_internal_templatebase.php(151) : eval()'d code on line 37 */


?>