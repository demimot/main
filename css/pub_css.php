<?php header('Content-Type: text/css; charset: UTF-8');
require_once($_SERVER["DOCUMENT_ROOT"]. '/config/dmm_config.php');

if(isset($_GET['piid'])){  
						
/* this function is only bringin a block of css from db... it will be better thought latter */
/* might also go through a css compressor funtion like */
$result = get_pub_issue_css($_GET['piid']);
echo $result['issue_css'];

}
?>