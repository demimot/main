<?php require_once($_SERVER["DOCUMENT_ROOT"]. '/config/dmm_config.php');
if(isset($_GET['piid'])){  
    if($result = get_pub_issue_css($_GET['piid'])){		
        /* this function is only bringin a block of css from db... it will be better thought latter */
        /* might also go through a css compressor funtion like */
        echo $result['issue_css'];
	}
}
header('Content-Type: text/css; charset: UTF-8');
?>