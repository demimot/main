<?php 
// phpinfo(); 

$count_p = 1;

$input = "plain

deep

deeper

deep

plain";

function parseTagsRecursive($input)
{
    global $count_p;
    $regex = '/\n(\s*\n)+/';

    if (is_array($input)) {
        $input = '</p><!--[$placeholder' . $count_p . ']--><p>'.$input[1];
		$count_p++;
    }

    return preg_replace_callback($regex, 'parseTagsRecursive', $input);
}

$output = "<p>" . parseTagsRecursive($input) ."</p>";

echo $output;
?>
