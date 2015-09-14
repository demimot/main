<?php 
foreach($_POST as $key => $value) {
    $_POST[$key] = clean_arrayorstring($value);
}

foreach($_GET as $key => $value) {
    $_GET[$key] = clean_arrayorstring($value);
}

function clean_arrayorstring($recvalue)
{
	if (is_array($recvalue))
	{
	    foreach($recvalue as $key => $value) 
		{
			$recvalue[$key] = clean_arrayorstring($value);
		}
	}
	else
	{
		$recvalue = strip_tags($recvalue); /* original htmlspecialchars(strip_tags($recvalue)) */
	}
	return $recvalue;	
}
?>