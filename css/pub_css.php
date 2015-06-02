<?php header('Content-Type: text/css; charset: UTF-8');
require_once($_SERVER["DOCUMENT_ROOT"]. '/config/dmm_config.php');

if(isset($_GET['pub'])){  
						
/* this function is only bringin a blck of css from db... it will be better thought latter */
/* might also go through a css compressor funtion like */
$result = get_pub_issue_css($_GET['pub']);
echo $result['issue_css'];

}
?>