<?php require($_SERVER["DOCUMENT_ROOT"] . '/Connections/dmm_db_connection.php'); 
	
## Session
if (!isset($session_id)) session_start();

## Setup site defaults 
define("DMM_DEFAULT_LANGUAGE", "pt");
define("DMM_MAX_LOGO_IMG_SIZE", 1000000);
define("DMM_DATE_FORMAT", "dd-mm-yyyy");
define("SMARTY_DATE_FORMAT", "%d-%b-%Y");
define("DMM_TITLE", "DemiMot - <span style='color:red;'>Beta</span>");

## img dir
function default_image_dir (){
	return "img/";
}

function page_not_found(){
	if (!strpos($_SERVER['REQUEST_URI'], "ta=")){
        $location = "Location: " . $_SERVER['REQUEST_URI'] . "/page-not-found";
	} else {
        $location = "Location: /page-not-found";
	}
    header($location);
    exit();
}

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

/* XSS form protection */
function set_form_xss(){
    return sha1(session_id() . rand());
}

## Anti Injection
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

// POST
function post_handler($the_POST)
{	
    $_return=0;
	if($_SESSION['form_xss'] != $the_POST['frm_xss']){
		return $_return;
	}
	
	if ($the_POST['frm_submit']==1 and !$_SESSION['user_id'])
	{
        $_return = login_in($the_POST);
        if(!$_return) $_SESSION['reset_pwd']=true; elseif(isset($_SESSION['reset_pwd'])) unset($_SESSION['reset_pwd']);
	} 
	elseif ($the_POST['frm_submit']==5 and !$_SESSION['user_id'] ) { // is to register AND no one logged in AND the terms of service are accepted
	// stilll validate whether every field is not empty
	    $response = $the_POST['g-recaptcha-response'];
	
	    $resp = url_get_contents ($response, $_SERVER['REMOTE_ADDR']);
		
	    if($resp['success']){
	        if(isset($the_POST['frm_terms'])){
	            $_return = user_registration($the_POST);
    		}else{
		        $_return = "signup?err=" . urlencode("terms acceptance failed");
		    }
		} else {
	        $_return = "signup?err=" . urlencode("captcha failed");			
		}
	}
	elseif (check_user_rights($the_POST['frm_pub_id'], $the_POST['frm_pub_issue_id'], $the_POST['frm_article_id'])) { // If the user is the owner (or, latter, if he has the right
        switch ($the_POST['frm_submit']) {
		    case 10:
    		    if($save_article = save_this_article($the_POST, $_SESSION['user_id']))
	    		{  
		    		if ($the_POST['frm_article_id']!="new"){
                        $_return = "/edit-article-" . $the_POST['frm_article_id'];
				    } else {
				        $_return = "/edit-article-" . $save_article;
    				}
	    		}
                break;
		    case 11:
			    if($the_POST['frm_image_verb']=="add"){
				$save_image_err = save_this_image($the_POST, "article", "picture");
    		        if($save_image_err!==UPLOAD_ERR_OK)
	    	    	{  
			    	    $_return = "/edit-article-" . $the_POST['frm_article_id'] . "?message=" . urlencode($save_image_err);
	    	    	} else  $_return = "/edit-article-" . $the_POST['frm_article_id'];
				} elseif($the_POST['frm_image_verb']=="update"){
					if($save_article = update_issue_article_image_properties($the_POST, $_SESSION['user_id']))
echo "<pre> 

                

";
include("dump_the_post.php");
echo "
</pre>";							
				}
				
				break;
    		case 20:
                if($save_pub = save_this_pub_basic_info($the_POST)){
		    		if($the_POST['frm_pub_id']!="new"){
			    		$_return = "/admin-pub-" . $the_POST['frm_pub_id'];
				    } else {
					    $_return = "/admin-pub-" . $save_pub;			 	
    				}
	            }
			    break;
            case 21:
	    		if($save_css = save_this_pub_css($the_POST)){
		    		$_return = "/admin-pub-" . $the_POST['frm_pub_id'];
			    }
    			break;				    
    		case 22:
                $save_image_err = save_this_image($the_POST, "pub", "logo");
		    	if($save_image_err!==UPLOAD_ERR_OK){
			        $_return = "/admin-pub-" . $the_POST['frm_pub_id'] . "?message=" . urlencode($save_image_err);
	            } else $_return = "/admin-pub-" . $the_POST['frm_pub_id'];
    	        break;
    		case 23: // add, change or delete sections from pub
    		    if($the_POST['frm_section_verb']=="delete"){
        			$resp = delete_pub_section_by_pub($the_POST['frm_pub_id'], $the_POST['frm_sections']);
    			} elseif($the_POST['frm_section_verb']=="add"){
    				$resp = add_pub_section_by_pub($the_POST['frm_pub_id'], $the_POST['frm_section_name'], $the_POST['frm_section_order']);
         		} 
				$_return = $resp ? "/admin-pub-" . $the_POST['frm_pub_id'] : $_return;
    			break;		
    		case 24:
                if($the_POST['frm_pub_issue_id']) $_return = "/admin-issue-" . $the_POST['frm_pub_issue_id'];
                break;	
    		case 25:
    		    if($new_issue = create_new_issue($the_POST['frm_pub_id']))
    			{  
                    /* Set the redirection here so once the issue is created we go straigth to the admin issues page */
    			    $_return = "/admin-issue-" . $new_issue ;
    			} else die();
    		    break;
    		case 26:
    		    if($the_POST['frm_pub_issue_id']) $_return = "/admin-issue-" . $the_POST['frm_pub_issue_id'];
    			break;
    		case 27:
    		    if($the_POST['frm_pub_staff_verb']=="delete"){
					if($the_POST['frm_pub_staff_user_id'] != $_SESSION['user_id']){
        			    $resp = delete_pub_staff_by_pub_user($the_POST['frm_pub_id'], $the_POST['frm_pub_staff_user_id']);
					}
    			} elseif($the_POST['frm_pub_staff_verb']=="add"){
    				$resp = add_pub_staff_by_pub_user($the_POST['frm_pub_id'], $the_POST['frm_pub_staff_user_id']);
         		} 
				$_return = $resp ? "/admin-pub-" . $the_POST['frm_pub_id'] : $_return;		
				break;
    		case 28:
    		    if($the_POST['frm_column_verb']=="delete"){
        			$resp = delete_pub_column_by_column_id($the_POST['frm_columns']);
    			} elseif($the_POST['frm_column_verb']=="add"){
    				$resp = add_pub_column_by_pub($the_POST['frm_pub_id'], $the_POST['frm_column_section'], $the_POST['column_staff_select'], $the_POST['frm_column_name']);
         		} 
				$_return = $resp ? "/admin-pub-" . $the_POST['frm_pub_id'] : $_return;
                break;
    		case 50:
			    if($the_POST['frm_pub_issue_id'] and save_this_issue_css($the_POST))
                break;	
    		case 51:
    		    if($the_POST['frm_section_verb']=="delete"){
        			$resp = delete_issue_section_by_issue($the_POST['frm_pub_issue_id'], $the_POST['frm_sections']);
    			} elseif($the_POST['frm_section_verb']=="add"){
					
    				$resp = add_issue_section_by_issue($the_POST['frm_pub_issue_id'], $the_POST['frm_section_name'], $the_POST['frm_section_order']);
         		} 
				$_return = $resp ? "/admin-issue-" . $the_POST['frm_pub_issue_id'] : $_return;
    			break;	
    		case 52:
			    if(if_not_published($the_POST['frm_pub_issue_id'])){
        	        $save_image_err = save_this_image($the_POST, "issue", "cover");
        		    if($save_image_err!==UPLOAD_ERR_OK){
                        $_return = "/admin-issue-" . $the_POST['frm_pub_issue_id']. "?msgcover=" . urlencode($save_image_err);
                    } else $_return = "/admin-issue-" . $the_POST['frm_pub_issue_id'];
				} else $_return = "/admin-issue-" . $the_POST['frm_pub_issue_id'];
    			break;	
    		case 53:
			    if(if_not_published($the_POST['frm_pub_issue_id'])){
    	            $save_image_err = save_this_image($the_POST, "issue", "logo");
    	    	    if($save_image_err!==UPLOAD_ERR_OK){
                        $_return = "/admin-issue-" . $the_POST['frm_pub_issue_id']. "?msglogo=" . urlencode($save_image_err);
                    } else $_return = "/admin-issue-" . $the_POST['frm_pub_issue_id'];
				} else $_return = "/admin-issue-" . $the_POST['frm_pub_issue_id'];
    			break;	
    		case 54:
    		    if($the_POST['frm_manage_content_verb']=="delete"){
        			$resp = discard_article($the_POST);
    			} elseif($the_POST['frm_manage_content_verb']=="add"){					
    				$resp = request_article($the_POST);
         		} elseif($the_POST['frm_manage_content_verb']=="update"){					
    				$resp = update_issue_article_properties($the_POST);
         		} 
				$_return = "/admin-issue-" . $the_POST['frm_pub_issue_id'];
                /*include("dump_the_post.php");
				echo "File: " . __FILE__ . " line: " . __LINE__ ;
                exit;	*/
    			break;	
    		case 55:	
				if(isset($the_POST['frm_pub_issue_article_id']) and $the_POST['frm_pub_issue_article_id']){ 
		            if($the_POST['frm_article_images_verb']=="confirm"){
            			$resp = confirm_article_images_by_issue($the_POST);
        			} 
    				$_return = "/admin-issue-" . $the_POST['frm_pub_issue_id'];
				}
    			break;	
    		case 56:	
				if(isset($the_POST['frm_article_id']) and $the_POST['frm_article_id']){ 
		            if($the_POST['frm_image_verb']=="add"){			
    			    	$save_image_err = save_this_image($the_POST, "issue", "article");
						if($save_image_err!==UPLOAD_ERR_OK){
			                $_return = "/admin-issue-" . $the_POST['frm_pub_issue_id'] . "?message=" . urlencode($save_image_err);
	                    }
         		    } elseif($the_POST['frm_image_verb']=="update"){					
    			    	$resp = update_issue_article_images_by_issue_article_image($the_POST);
         	    	} elseif($the_POST['frm_image_verb']=="delete"){					
    	    			$resp = remove_issue_article_images_by_issue_article_image($the_POST);
             		} 
    				
				}
    			break;	
    		case 100:
			    if($the_POST['frm_check_publish_issue'] and if_not_published($the_POST['frm_pub_issue_id'])){
					if (blocked_by_articles($the_POST['frm_pub_issue_id'])){
					$_return = "/admin-issue-" . $the_POST['frm_pub_issue_id'] . "?blocking=true";
					} else {
                    $_return = "read-" . publish_issue($the_POST['frm_pub_issue_id']);
					}
				}
    			break;	
            default:    
				echo "<pre>

                

";
include("dump_the_post.php");
echo "
</pre>";			  
        }
	}
	
    unset($_POST);
    $_SESSION['form_xss'] = set_form_xss();
    return $_return;
}


/*****************************************************************************
 ************                 Get stuff Functions                 ************ 
 *****************************************************************************/
function login_in($the_data){
	    $_return=0;
        $this_username=GetSQLValueString($the_data['frm_username'], "text");
        $this_password=GetSQLValueString(sha1("tamarindo" . trim($the_data['frm_password'])), "text");
		
		global $dmm_db_connection;
        $query_Recordset1 = "SELECT dmm_users.user_id FROM dmm_users WHERE dmm_users.user_validated AND dmm_users.user_username=" . $this_username . " AND dmm_users.user_pwd=" . $this_password;
        $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
        if($row_Recordset1 = mysql_fetch_assoc($Recordset1)){
            $_SESSION['user_id'] = intval($row_Recordset1['user_id']);
            $_return = ($the_data['called_from']!="/login")?$the_data['called_from']:"/";	
        }
		return $_return;	
} 
 
function check_user_rights($pub_id, $pub_issue_id, $article_id=NULL){
	global $dmm_db_connection;
	$query_Recordset1 = "SELECT DISTINCT dmm_pubs.user_id FROM dmm_pubs 
	                     LEFT JOIN dmm_pub_issues ON dmm_pubs.pub_id = dmm_pub_issues.pub_id
                         WHERE dmm_pubs.user_id=" . $_SESSION['user_id'] . " 
					     AND (dmm_pubs.pub_id = " . GetSQLValueString($pub_id, "int") . "
                         OR dmm_pub_issues.pub_issue_id = " . GetSQLValueString($pub_issue_id, "int") . ") OR " . GetSQLValueString($pub_id, "int") . "='new' OR " . GetSQLValueString($article_id, "int") . "='new' 
						 UNION
                         SELECT DISTINCT dmm_articles.article_author_id as user_id from dmm_articles Where article_id = " . GetSQLValueString($article_id, "int") . " 
                         LIMIT 1";			 
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());	
    if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	{
		$return = $row_Recordset1;
	}else $return=0;
	return $return;	
}
 
 
function have_pubs($user_id)
{
	$return=array();
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT pub_name, pub_slug, pub_country, pub_language, pub_id, pub_tstamp FROM dmm_pubs WHERE user_id=" . GetSQLValueString($user_id, "int");
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;
}

function blocked_by_articles($pub_issue_id){
	$return=0;
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT a.article_id FROM dmm_pub_issue_articles pia INNER JOIN dmm_articles a  ON pia.pub_issue_id = a.article_pub_issue_id WHERE pia.pub_issue_id=" . GetSQLValueString($pub_issue_id, "int") . " and NOT a.article_ready LIMIT 1";
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	{
		$return = $row_Recordset1;
	}
	return $return;	
}

function get_pubs_of_contibuter($user_id){
	$return=array();
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT ps.dmm_pub_id as pub_id, p.pub_name FROM dmm_pub_staff ps INNER JOIN dmm_pubs p on ps.dmm_pub_id = p.pub_id WHERE ps.dmm_user_id = " . GetSQLValueString($user_id, "int"). " order by p.pub_name";
	$Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;	
}

function get_columns_by_pub($pub_id){
	$return=array();
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT column_id, pub_id, section_id, user_id, column_name from dmm_pub_columns_template where pub_id = " . GetSQLValueString($pub_id, "int");
	$Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection);	
    while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;	
}

function get_staff_by_pub($pub_id){
	$return=array();
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT s.dmm_user_id as user_id, u.user_nickname from dmm_pub_staff s inner join dmm_users u on s.dmm_user_id=u.user_id where s.dmm_pub_id = " . GetSQLValueString($pub_id, "int") . " ORDER BY u.user_nickname";
	$Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection);	
    while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;	
}

function get_featured($search="",$limit="12")
{
	$return=array();
    global $dmm_db_connection; /* SQL Esta correto !!! mas... featured nao esta definido mesmo ainda... */
	$query_base = "SELECT i.pub_id, i.pub_issue_id, i.pub_issue, p.pub_name, p.pub_mote, p.pub_slug, i.pub_issue_cover FROM dmm_pub_issues i inner join dmm_pubs p on i.pub_id = p.pub_id WHERE i.pub_issue_id IN (
SELECT max(pub_issue_id) as pub_issue_id FROM dmm_pub_issues WHERE pub_issue_published group by pub_id)";
	if($search){
		$query_base .= " AND p.pub_name like " . GetSQLValueString("%". $search . "%", "text") . " ";
	}
    $query_Recordset1 = $query_base . " LIMIT " . $limit;	
	//echo $query_Recordset1; exit;
	$Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;
}

function pub_handler($pub)
{
	$return=0;
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT i.pub_id, i.pub_issue_id, pub_issue, i.pub_issue_cover, UNIX_TIMESTAMP(i.pub_issue_tstamp) as pub_issue_tstamp, p.pub_name, p.pub_mote, p.pub_slug FROM dmm_pub_issues i inner join dmm_pubs p on i.pub_id = p.pub_id WHERE i.pub_issue_id=" . GetSQLValueString($pub, "int") . " and i.pub_issue_published";
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	{
		$return = $row_Recordset1;
	}
	return $return;	
}

function get_old_issues ($pub_id, $last_issue){
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT i.pub_issue_id, pub_issue, i.pub_issue_cover, UNIX_TIMESTAMP(i.pub_issue_tstamp) as pub_issue_tstamp, p.pub_name, p.pub_slug FROM dmm_pub_issues i inner join dmm_pubs p on i.pub_id = p.pub_id WHERE i.pub_id=" . GetSQLValueString($pub_id, "int") . " and i.pub_issue not in(" . GetSQLValueString($last_issue, "int") . ") and i.pub_issue_published order by i.pub_issue desc"; 
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;	
}


function get_pub_by_slug($slug, $pid=NULL, $preview=0)
{
	$return=array();
    global $dmm_db_connection; 
	if(is_null($pid)){
        $query_Recordset1 = "SELECT i.pub_id, i.pub_issue_id, i.pub_issue, i.pub_issue_logo,  UNIX_TIMESTAMP(i.pub_issue_tstamp) as pub_issue_tstamp, p.pub_name, p.pub_mote, p.pub_slug, i.pub_issue_cover, p.user_id FROM dmm_pub_issues i inner join dmm_pubs p on i.pub_id = p.pub_id WHERE i.pub_issue_id IN (
SELECT max(pub_issue_id) as pub_issue_id
FROM dmm_pub_issues WHERE  (pub_issue_published OR 1=" . GetSQLValueString($preview, "int") . ") group by pub_id) and p.pub_slug=" . GetSQLValueString($slug, "text") . " limit 1";
	} else {
		$query_Recordset1 = "SELECT i.pub_id, i.pub_issue_id, i.pub_issue, i.pub_issue_logo,  UNIX_TIMESTAMP(i.pub_issue_tstamp) as pub_issue_tstamp, p.pub_name, p.pub_mote, p.pub_slug, i.pub_issue_cover, p.user_id FROM dmm_pub_issues i inner join dmm_pubs p on i.pub_id = p.pub_id WHERE i.pub_issue=" . GetSQLValueString($pid, "int") . " AND (pub_issue_published OR 1=" . GetSQLValueString($preview, "int") . ") and p.pub_slug=" . GetSQLValueString($slug, "text") . " limit 1";
	}
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	{
		$return = $row_Recordset1;
	}else $return=0;
	return $return;
}

function get_articles_by_issue($pub_issue, $content=true)
{  // $content means... whethet you want all content or only ids and title...
    global $dmm_db_connection;
	$return=array();
	$whole_content = ($content) ? "a.article_subtitle, a.article_body, (SELECT pp.pub_name FROM dmm_pub_issues pi INNER JOIN dmm_pubs pp ON pi.pub_id = pp.pub_id WHERE pi.pub_issue_id = a.article_pub_issue_id AND a.article_pub_issue_id!=" . GetSQLValueString($pub_issue, "int") . ") as article_source, " : "";
    $query_Recordset1 = "SELECT a.article_id, article_author_id, a.article_title, a.article_ready, " . $whole_content . " a.article_pub_issue_id, DATE_FORMAT(a.article_deadline, '%d-%m-%Y') as article_deadline, i.section_id , i.article_weight, i.use_article_images FROM dmm_pub_issue_articles i INNER JOIN dmm_articles a ON i.article_id = a.article_id WHERE i.pub_issue_id=" . GetSQLValueString($pub_issue, "int") . "";
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }

	return $return;	
}

function get_published_articles_by_author($authid){
    global $dmm_db_connection;
	$return=array();
    $query_Recordset1 = "SELECT a.article_id, a.article_title, p.pub_issue, p.pub_issue_id, p.pub_issue_published, a.article_pub_issue_id, (SELECT pp.pub_name FROM dmm_pub_issues pi INNER JOIN dmm_pubs pp ON pi.pub_id = pp.pub_id WHERE pi.pub_issue_id = a.article_pub_issue_id) as article_source FROM dmm_articles a LEFT JOIN dmm_pub_issues p on a.article_pub_issue_id = p.pub_issue_id WHERE p.pub_issue_published and a.article_author_id=" . GetSQLValueString($authid, "int") . " order by a.article_id DESC";
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;	
}

function get_unpublished_articles_by_author($authid){
    global $dmm_db_connection;
	$return=array();
    $query_Recordset1 = "SELECT a.article_id, a.article_title, p.pub_issue, p.pub_issue_id, p.pub_issue_published, a.article_pub_issue_id, 
	                       (SELECT pp.pub_name FROM dmm_pub_issues pi INNER JOIN dmm_pubs pp ON pi.pub_id = pp.pub_id  WHERE pi.pub_issue_id = a.article_pub_issue_id
                            UNION 
		                    SELECT ppp.pub_name FROM dmm_pubs ppp WHERE ppp.pub_id = a.article_spontaneous limit 1) as article_source
                         FROM dmm_articles a LEFT JOIN dmm_pub_issues p           on a.article_pub_issue_id = p.pub_issue_id 
                         WHERE (not p.pub_issue_published or isnull(p.pub_issue_published)) AND a.article_author_id =" . GetSQLValueString($authid, "int") . " order by a.article_id DESC";
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;	
}

function article_images_handler($article_id)
{
    global $dmm_db_connection;
	$return=array();
    $query_Recordset1 = "SELECT `article_image_filename` ,  `article_image_caption` ,  `article_image_credits` FROM  `dmm_article_images` WHERE  `article_id`=" . GetSQLValueString($article_id, "int") ." ORDER BY  `article_image_weight`" ;  
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }

	return $return;	
}

function get_user_data($user_id)
{
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT user_firstname, user_lastname, user_nickname, user_email, user_tel FROM dmm_users WHERE dmm_users.user_id=" . GetSQLValueString($user_id, "int");
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	{
		$return = $row_Recordset1;
	}else $return=0;
	return $return;		
}

function get_pub_issue_css($pub_issue_id)
{
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT pub_issue_css, UNIX_TIMESTAMP(pub_issue_css_tstamp) as pub_issue_css_tstamp FROM dmm_pub_issue_css WHERE pub_issue_id=" . GetSQLValueString($pub_issue_id, "int");
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	{
		$return = $row_Recordset1;
	}else $return="";
	
	return $return;		
}


function get_article_by_id($artid, $public=0) {
    global $dmm_db_connection;
    $query_Recordset1 = "select a.*, pid.pub_issue, pid.pub_issue_published, p.pub_name from dmm_pub_issues pid inner join dmm_pubs p on pid.pub_id = p.pub_id right join dmm_articles a on pid.pub_issue_id = a.article_pub_issue_id where a.article_id=" . GetSQLValueString($artid, "int") ; 
	$query_Recordset1 = ($public) ? $query_Recordset1 : $query_Recordset1 . " and article_author_id=" . GetSQLValueString($_SESSION['user_id'], "int");
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	{
		$return = $row_Recordset1;
	}else $return="";
	return $return;		
}

function get_pub_by_pub_id($pubid) {
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT * FROM dmm_pubs WHERE pub_id=" . GetSQLValueString($pubid, "int") . " and user_id=" . GetSQLValueString($_SESSION['user_id'], "int");
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	{
		$return = $row_Recordset1;
	}
	
	if($this_pub_sections = get_sections_from_template_by_pub($_GET['pubid'])){
        $return['pub_sections'] = array();
        $return['pub_sections'] = $this_pub_sections;
	}
						
	if($this_pub_unpublished_issues = get_issues_by_pub($_GET['pubid'])){
        $return['pub_unpublished_issues'] = array();
        $return['pub_unpublished_issues'] = $this_pub_unpublished_issues;
	}

    if($this_pub_published_issues = get_issues_by_pub($_GET['pubid'], 1)){
        $return['pub_published_issues'] = array();
        $return['pub_published_issues'] = $this_pub_published_issues;
	}
	
	if($this_pub_columns = get_columns_by_pub($_GET['pubid'])){
        $return['pub_columns'] = array();
        $return['pub_columns'] = $this_pub_columns;
	}

    if($this_pub_staff = get_staff_by_pub($_GET['pubid'])){
        $return['pub_staff'] = array();
        $return['pub_staff'] = $this_pub_staff;
	}
	return $return;		
}

function get_pub_types($language, $where=0){
    global $dmm_db_connection;
	$return=array();
    $query_Recordset1 = "SELECT pub_type_id, pub_type_" . $language . " as pub_type FROM pub_types ";
	if($where) $query_Recordset1 .= " WHERE pub_type_id = " . GetSQLValueString($where, "int") ;
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
        $return[]=$row_Recordset1;
    }
	return $return;			
}

function get_pub_income_status($language, $where=0){
    global $dmm_db_connection;
	$return=array();
    $query_Recordset1 = "SELECT pub_income_id, pub_income_" . $language . " as pub_income FROM pub_income_status ";
	if($where) $query_Recordset1 .= " WHERE pub_income_id= " . GetSQLValueString($where, "int") ;
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
        $return[]=$row_Recordset1;
    }
	return $return;			
}

function get_sections_from_template_by_pub($pubid) {
    global $dmm_db_connection;
	$return=array();
    $query_Recordset1 = "SELECT ps.section_id, ps.section_name, ps.section_order, p.user_id FROM dmm_pub_sections_template AS ps INNER JOIN dmm_pubs AS p ON ps.pub_id = p.pub_id WHERE ps.pub_id=" . GetSQLValueString($pubid, "int") . " and p.user_id=" . GetSQLValueString($_SESSION['user_id'], "int") . " order by ps.section_order";
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;		
}

function get_sections_by_issue($pubid) {
    global $dmm_db_connection;
	$return=array();
    $query_Recordset1 = "SELECT section_id, section_weight, section_name, section_order FROM dmm_pub_issue_sections WHERE pub_issue_id=" . GetSQLValueString($pubid, "int") . " ORDER BY section_order";
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;		
}

function get_issues_by_pub($pubid, $published=0) {
    global $dmm_db_connection;
	$return=array();
    $query_Recordset1 = "SELECT pi.pub_issue, pi.pub_issue_id, p.pub_name, p.pub_name FROM dmm_pub_issues AS pi INNER JOIN dmm_pubs AS p ON pi.pub_id = p.pub_id WHERE pi.pub_id = " . GetSQLValueString($pubid, "int") . " AND pi.pub_issue_published = " . GetSQLValueString($published, "int") . " AND p.user_id = " . GetSQLValueString($_SESSION['user_id'], "int") . " ORDER BY pi.pub_issue_id DESC";
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;		
}

function get_this_issue_data($piid) {
    global $dmm_db_connection;
	$return=0;
    $query_Recordset1 = "SELECT pi.pub_id, pi.pub_issue, pi.pub_issue_id, p.pub_name, p.pub_slug, pi.pub_issue_cover, UNIX_TIMESTAMP(pi.pub_issue_tstamp) as pub_issue_tstamp, pi.pub_issue_logo, pi.pub_issue_published FROM dmm_pub_issues AS pi INNER JOIN dmm_pubs AS p ON pi.pub_id = p.pub_id WHERE pi.pub_issue_id = " . GetSQLValueString($piid, "int") . " AND p.user_id = " . GetSQLValueString($_SESSION['user_id'], "int");
    if($Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error())){
	    if($row_Recordset1 = mysql_fetch_assoc($Recordset1)) $return = $row_Recordset1;

        if ($this_css = get_pub_issue_css($piid, $this_css)) $return['pub_issue_css']=$this_css['pub_issue_css'];	
		
	    if ($this_sections = get_sections_by_issue($piid) and $this_sections){
	    	$return['issue_sections'] = array();
	        $return['issue_sections'] = $this_sections;	
	    }
	
	    if($this_articles = get_articles_by_issue($piid, false)){ // false = we don't need all data here... just ids and title
	    	$return['issue_articles'] = array();
	        $return['issue_articles'] = $this_articles;
	    }
	
	    if($this_staff = get_staff_by_pub($return['pub_id'])){
		    $return['issue_staff'] = array();
	        $return['issue_staff'] = $this_staff;
	    }
	}
	return $return;		
}

function if_not_published($issue_id){
    global $dmm_db_connection;
	$return=0;
	$query_Recordset1 = "SELECT pub_issue_published from dmm_pub_issues WHERE pub_issue_id = " . GetSQLValueString($issue_id, "int");
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	{
		$return = !$row_Recordset1['pub_issue_published'];
	}	return $return;		
}

function get_article_by_pub_issue_slug($pid, $slug) {
    global $dmm_db_connection;
	
	$query_Recordset1 = "SELECT a.article_id, a.article_title, article_subtitle, article_body, (SELECT pp.pub_name FROM dmm_pub_issues pi INNER JOIN dmm_pubs pp ON pi.pub_id = pp.pub_id WHERE pi.pub_issue_id = a.article_pub_issue_id AND pi.pub_issue_id!=" . GetSQLValueString($pid, "int") . ") as article_source, 
a.article_pub_issue_id FROM dmm_pub_issue_articles i INNER JOIN dmm_articles a ON i.article_id = a.article_id WHERE a.article_slug=" . GetSQLValueString($slug, "text") . " and i.pub_issue_id=" . GetSQLValueString($pid, "int");

    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	{
		$return = $row_Recordset1;
	}else $return="";
	return $return;		
}

function get_article_images($article_id){
    if($article_id){
		$return=array();
        global $dmm_db_connection;
        $query_Recordset1 = "SELECT article_image_id, article_image_filename, article_image_caption, article_image_credits, article_image_weight FROM dmm_article_images WHERE article_id=" . GetSQLValueString($article_id, "int") . " ORDER BY article_image_weight";
		// echo $query_Recordset1; exit;
        $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
        while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
            $return[]=$row_Recordset1;
        }
	} else {$return = null;}
    return $return;    
}



/*****************************************************************************
 ************              Insert / update Functions              ************ 
 *****************************************************************************/
function update_issue_article_images_by_issue_article_image($the_post){
    $_return = false;
	global $dmm_db_connection;
    if(	$the_post['frm_article_image_id'] ){
		$query_Recordset1="UPDATE dmm_issue_article_images set article_image_caption=" . GetSQLValueString($the_post['frm_image_caption'], "text") . ", 
		                   article_image_credits=" . GetSQLValueString($the_post['frm_image_copyright'], "text") . ", article_image_weight=" . GetSQLValueString($the_post['frm_image_weight'], "int") . " 
						   WHERE issue_article_image_id=" . GetSQLValueString($the_post['frm_article_image_id'], "int") . " AND article_id=" . GetSQLValueString($the_post['frm_article_id'], "int") . "
                           AND issue_id=" . GetSQLValueString($the_post['frm_pub_issue_id'], "int") . " 
						   AND NOT (Select pub_issue_published FROM dmm_pub_issues WHERE pub_issue_id = " . GetSQLValueString($the_post['frm_pub_issue_id'], "int") . ")";
        if($_resp = mysql_query($query_Recordset1, $dmm_db_connection)){
            $_return = true;
		}
	}	
	return $_return;
}

function remove_issue_article_images_by_issue_article_image($the_post){
    $_return = false;
	global $dmm_db_connection;
    if(	$the_post['frm_article_image_id'] ){ //NOT image_source means image was added to the issue (image_source=0) and does not belong to the original article (image_source=1) (1==true);
		$query_Recordset1="Select article_image_filename FROM dmm_issue_article_images WHERE issue_article_image_id=" . GetSQLValueString($the_post['frm_article_image_id'], "int") . " 
		                   AND article_id=" . GetSQLValueString($the_post['frm_article_id'], "int") . " AND issue_id=" . GetSQLValueString($the_post['frm_pub_issue_id'], "int") . " 
						   AND NOT image_source 
						   AND NOT (Select pub_issue_published FROM dmm_pub_issues WHERE pub_issue_id = " . GetSQLValueString($the_post['frm_pub_issue_id'], "int") . ")";
        $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
		if($row_Recordset1 = mysql_fetch_assoc($Recordset1)) {
			$image_filename = $row_Recordset1['article_image_filename'];						   
		    $query_Recordset1="DELETE FROM dmm_issue_article_images 
		                       WHERE issue_article_image_id=" . GetSQLValueString($the_post['frm_article_image_id'], "int") . " AND article_id=" . GetSQLValueString($the_post['frm_article_id'], "int") . "
							   AND issue_id=" . GetSQLValueString($the_post['frm_pub_issue_id'], "int") . " 
							   AND NOT image_source 
							   AND NOT (Select pub_issue_published FROM dmm_pub_issues WHERE pub_issue_id = " . GetSQLValueString($the_post['frm_pub_issue_id'], "int") . ")";
            if($_resp = mysql_query($query_Recordset1, $dmm_db_connection)){
                $_return = true;
                unlink(default_image_dir() . "$image_filename");
			}
		}
	}	
	
/*	echo "<pre>

                

";
include("dump_the_post.php");
echo "
</pre>";		
	*/
}

function confirm_article_images_by_issue ($the_post){
    $_return = false;
	global $dmm_db_connection;
    if(	$the_post['frm_pub_issue_article_id']  and $the_post['frm_pub_issue_id'] and if_not_published($the_post['frm_pub_issue_id']) ){
            $query_Recordset1= "DELETE from dmm_issue_article_images WHERE issue_id=".GetSQLValueString($the_post['frm_pub_issue_id'], "int")." AND article_id=".GetSQLValueString($the_post['frm_pub_issue_article_id'], "int").
			                   " AND image_source = 1";
			$_resp = mysql_query($query_Recordset1, $dmm_db_connection);
		if($the_post['frm_use_article_images']){
            $query_Recordset1= "INSERT INTO dmm_issue_article_images (issue_id, article_image_id, article_id, article_image_weight, article_image_filename, article_image_caption, article_image_credits, image_source)
			                    SELECT " . GetSQLValueString($the_post['frm_pub_issue_id'], "int") . ", ai.article_image_id, ai.article_id, ai.article_image_weight, ai.article_image_filename, ai.article_image_caption, 
								ai.article_image_credits, 1 from dmm_article_images ai WHERE ai.article_id=" . GetSQLValueString($the_post['frm_pub_issue_article_id'], "int") ;
			$_resp = mysql_query($query_Recordset1, $dmm_db_connection);
		}
		$query_Recordset1= "UPDATE dmm_pub_issue_articles SET use_article_images = " . ((isset($the_post['frm_use_article_images']) and $the_post['frm_use_article_images']) ? 1 : 0) . 
                           " WHERE pub_issue_id = " . GetSQLValueString($the_post['frm_pub_issue_id'], "int") . " and article_id = " . GetSQLValueString($the_post['frm_pub_issue_article_id'], "int") ;
						  // echo $query_Recordset1;exit;
        if($_resp = mysql_query($query_Recordset1, $dmm_db_connection)){
            $_return = true;
		}
	}
	return $_return;
}
 
function activate_user($user_id, $user_hash){
    $_return = false;
	global $dmm_db_connection;
    if(	$user_id and $user_hash ){
		$query_Recordset1="UPDATE dmm_users set user_validated=1 WHERE user_id=" .GetSQLValueString($user_id, "int") ." AND user_validated=0 AND SHA1(user_pwd) = " .GetSQLValueString($user_hash, "text");
        if($_resp = mysql_query($query_Recordset1, $dmm_db_connection)){
            $_return = true;
		}
	}
	return $_return;
} 
 
function user_registration($the_data){
	global $dmm_db_connection;
    $_return="/signup";
	$_err = "";
    if (trim($the_data['frm_passworda'])==trim($the_data['frm_passwordb'])) { $this_password=GetSQLValueString(sha1("tamarindo" . trim($the_data['frm_passworda'])), "text");} else {$err = "?err=password+mismatch";}
	if (trim($the_data['frm_emaila'])==trim($the_data['frm_emailb'])){ $this_email=GetSQLValueString($the_data['frm_emaila'], "text"); }  else {$err = "?err=e-mail+mismatch";}
	if (!trim($the_data['frm_username'])) $err = "?err=username+mandatory";
	if (!trim($the_data['frm_passworda'])) $err = "?err=password+mandatory";
	if (!trim($the_data['frm_firstname'])) $err = "?err=first+name+mandatory";
	if (!trim($the_data['frm_lastname'])) $err = "?err=last+name+mandatory";
	if (!trim($the_data['frm_nickname'])) $err = "?err=nickname+mandatory";
	if (!trim($the_data['frm_emaila'])) $err = "?err=e-mail+mandatory";
	$this_username=GetSQLValueString($the_data['frm_username'], "text");
	if($this_password and $this_email and !$err){
        global $dmm_db_connection;
        $query_Recordset1 = "SELECT dmm_users.user_id FROM dmm_users WHERE dmm_users.user_username=" . $this_username . " OR dmm_users.user_email=" . $this_email;
        $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
        if($row_Recordset1 = mysql_fetch_assoc($Recordset1)){
			$err = "?err=user+exist&un=".$the_data['frm_username'];
        } 
		else {
			// ATTENTION... STILL NEEDS TO email user with a link to activate...
			// AND>.... make login dependent on activation of course
			$query_Recordset1 = "INSERT into dmm_users (user_username, user_pwd, user_firstname, user_lastname, user_nickname, user_email, user_tel) values (" . $this_username . "," . 
			                     $this_password . "," . GetSQLValueString($the_data['frm_firstname'], "text") . "," . GetSQLValueString($the_data['frm_lastname'], "text") . "," . 
			                     GetSQLValueString($the_data['frm_nickname'], "text") . "," . $this_email . "," . GetSQLValueString($the_data['frm_telnumber'], "text") . ")" ;
			if($Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) ){
				$lastid=mysql_insert_id();
				
                $to                          = $the_data['frm_emaila'];
                $email_randomstr             = sha1("tamarindo" . trim($the_data['frm_passworda']));
                $email_randomstr             = sha1($email_randomstr);
                // set mail TEXT content
                $mailmessage               = "";
                // set subject
                $subject                   = "Demi Mot Account activation: " . $registrant_email;
                //introduction (e-mail)
                $mailmessage               = '' . date("jS-M-Y") . "\r\n\r\n
				
Dear ". trim($the_data['frm_firstname']) . ",\r\n\r\n
Welcome to Demi Mot! \r\n\r\n
Please follow the link below to activate your Demi Mot account. \r\n\r\n
https://www.demimot.com/account-validation-" . $lastid ."/ars-" . $email_randomstr . "\r\n\r\n
If you have trouble using the link above in your e-mail client please copy and paste the url to your browser.\r\n\r\n
Thank you,\r\n\r\n
Demi Mot Team";
                // set mail header (html)
				$headers                  = 'From: Demi Mot <no-reply@demimot.com>' . "\r\n";
				$headers                 .= 'Sender: info@demimot.com' . "\r\n";
				$headers                 .= 'Reply-To: info@demimot.com' . "\r\n";
				$headers                 .= 'MIME-Version: 1.0' . "\r\n"; 
				$headers                 .= 'Content-type: text/plain;charset=utf-8' . "\r\n";
				$headers                 .= 'Content-Transfer-Encoding: 8bit' . "\r\n";
				
				// mail($to,$subject,$mailmessage,$headers);  
				mail($to, "=?utf-8?B?".base64_encode($subject)."?=", $mailmessage, $headers);
				
				// Now inform us ...
				$to                        = "julio@demimot.com";
				$subject                   = "  New user registered - " . date("jS-M-Y");
				$mailmessage               = '  account created: ' . $the_data['frm_emaila']  . "\r\n\r\n" . trim($the_data['frm_firstname']) . ' ' . trim($the_data['frm_lastname']);
				
				mail($to, "=?utf-8?B?".base64_encode($subject)."?=", $mailmessage, $headers);
				
			    $err="";
				$_return = "/validation-warning-" . $lastid;
//                include("dump_the_post.php");
//                echo "File: " . __FILE__ . " line: " . __LINE__ ;	
			}
		}
	}
	
    $_return .= $err;   	
	return $_return;
	
} 


function add_pub_section_by_pub($pub_id, $section_name, $section_order=0){
    $return=0; 
	if (trim($section_name)!=""){
        global $dmm_db_connection;
	    // get next Section ID value (even if there are "holes" in the sequence"
    	if($return = save_pub_old_sections($pub_id)){
		    $query_Recordset1 = "insert into dmm_pub_sections_template (pub_id, section_id, section_name, section_order) SELECT  " . GetSQLValueString($pub_id, "int") . ", ifnull((max(ps.section_id) + 1),1), " . GetSQLValueString($section_name, "text") . ", "   . GetSQLValueString($section_order, "int") . " FROM dmm_pub_sections_template ps WHERE ps.pub_id = " . GetSQLValueString($pub_id, "int");
		
    	    $return = mysql_query($query_Recordset1, $dmm_db_connection);
	    }
	}
	return $return;	
}

function add_pub_column_by_pub($pub_id, $section_id, $user_id, $column_name){
    $return=0;
    global $dmm_db_connection;
    $query_Recordset1 = "insert into dmm_pub_columns_template (pub_id, section_id, user_id, column_name) values (" . GetSQLValueString($pub_id, "int") . 
	                    ", " . GetSQLValueString($section_id, "int") . ", " . GetSQLValueString($user_id, "int") . ", " . GetSQLValueString($column_name, "text") . ")";
    $return = mysql_query($query_Recordset1, $dmm_db_connection);
	return $return;
}

function add_pub_staff_by_pub_user($pub_id, $user_id){
    $return=0; 
    global $dmm_db_connection;
    $query_Recordset1 = "insert into dmm_pub_staff (dmm_pub_id, dmm_user_id) values (" . GetSQLValueString($pub_id, "int") . ", " . GetSQLValueString($user_id, "int") . ")";
    $return = mysql_query($query_Recordset1, $dmm_db_connection);
	return $return;	
}



function add_issue_section_by_issue($pub_issue_id, $section_name, $section_order=0){
    $return=0; 
    global $dmm_db_connection;
	if (trim($section_name)!="" and if_not_published($pub_issue_id)){
	    // get next Section ID value (even if there are "holes" in the sequence"
    	if($return = save_issue_old_sections($pub_issue_id)){
		    $query_Recordset1 = "insert into dmm_pub_issue_sections (pub_issue_id, section_id, section_name, section_order) SELECT  " . GetSQLValueString($pub_issue_id, "int") . ", ifnull((max(pis.section_id) + 1),1), " . GetSQLValueString($section_name, "text") . ", "   . GetSQLValueString($section_order, "int") . " FROM dmm_pub_issue_sections pis WHERE pis.pub_issue_id = " . GetSQLValueString($pub_issue_id, "int");
		    //echo $query_Recordset1; exit;
    	    $return = mysql_query($query_Recordset1, $dmm_db_connection);
	    }
	}
	return $return;	
}

function save_this_pub_css($this_pub){
    global $dmm_db_connection;
	$return=0;
    if($return = save_old_pub_details($this_pub['frm_pub_id'], "css")){
		$query_Recordset1 = "update dmm_pubs set pub_css=" . GetSQLValueString($this_pub['frm_publication_css'], "text") . " WHERE pub_id = " . GetSQLValueString($this_pub['frm_pub_id'], "int");
        $return = mysql_query($query_Recordset1, $dmm_db_connection);
	}
    return $return;
}

function save_this_issue_css($this_issue){
    global $dmm_db_connection;
	$return=0;
	if (if_not_published($this_issue['frm_pub_issue_id'])){
        if($return = save_old_issue_css($this_issue['frm_pub_issue_id'])){
		    $query_Recordset1 = "update dmm_pub_issue_css set pub_issue_css=" . GetSQLValueString($this_issue['frm_issue_css'], "text") . " WHERE pub_issue_id = " . GetSQLValueString($this_issue['frm_pub_issue_id'], "int");
            $return = mysql_query($query_Recordset1, $dmm_db_connection);
	    }
	}
    return $return;
}

function update_issue_article_image_properties($the_POST){
    global $dmm_db_connection;
	$return=0;
	if (if_not_published($the_POST['frm_pub_issue_id'])){
		    $query_Recordset1 = "UPDATE dmm_article_images SET article_image_weight=" . GetSQLValueString($the_POST['frm_image_weight'], "int") . 
			                    ", article_image_caption=" . GetSQLValueString($the_POST['frm_image_caption'], "text") . ", article_image_credits=" . GetSQLValueString($the_POST['frm_image_copyright'], "text") . 
								" WHERE article_image_id = " . GetSQLValueString($the_POST['frm_article_image_id'], "int") . " AND article_id=" . GetSQLValueString($the_POST['frm_article_id'], "int");
            $return = mysql_query($query_Recordset1, $dmm_db_connection);
	}
    return $return;
}

function save_this_image ($this_data, $img_destination, $image_usage)
{
    global $dmm_db_connection;
	$return="";
   
    try {
        // Undefined | Multiple Files | $_FILES Corruption Attack
        // If this request falls under any of them, treat it invalid.
        if ( !isset($_FILES['frm_image_upload']['error']) ||  is_array($_FILES['frm_image_upload']['error']) ) {
            throw new RuntimeException('Invalid parameters.');
        }

        // Check $_FILES['frm_image_upload']['error'] value.
		$return=$_FILES['frm_image_upload']['error'];
        switch ($return) {
            case UPLOAD_ERR_OK:
                 Break;
            case UPLOAD_ERR_NO_FILE:
                throw new RuntimeException('No file sent.');
				break;   
            case UPLOAD_ERR_INI_SIZE:
            case UPLOAD_ERR_FORM_SIZE:
                throw new RuntimeException('Exceeded filesize limit.');
				break;   
		    case UPLOAD_ERR_CANT_WRITE:
                throw new RuntimeException("Can't write to disk.");			 
				break;   
            default:
                throw new RuntimeException('Unknown errors.');
        }

        // You should also check filesize here. 
        if ($_FILES['frm_image_upload']['size'] > DMM_MAX_LOGO_IMG_SIZE) {
            throw new RuntimeException('Exceeded filesize limit.');
        }

        // DO NOT TRUST $_FILES['frm_image_upload']['mime'] VALUE !!
        // Check MIME Type by yourself.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search($finfo->file($_FILES['frm_image_upload']['tmp_name']), array('jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif',), true)) {
            throw new RuntimeException('Invalid file format.');
        }

        // On this example, obtain safe unique name from its binary data.
		$file_name = sha1(sha1_file($_FILES['frm_image_upload']['tmp_name']). session_id());
		if (file_exists(default_image_dir () . $file_name . "." . $ext)){
            throw new RuntimeException('File already exists');			
		}

	    if (!move_uploaded_file($_FILES['frm_image_upload']['tmp_name'], default_image_dir () . $file_name . "." . $ext)) {
            throw new RuntimeException('Failed to move uploaded file.');
        }
		else {
			if($img_destination == "pub"){
                if($save_pub = save_old_pub_details($this_data['frm_pub_id'], "logo")){
        		    $query_Recordset1 = "UPDATE dmm_pubs set pub_logo=" . GetSQLValueString($file_name . "." . $ext, "text") . " WHERE pub_id = " . GetSQLValueString($this_data['frm_pub_id'], "int");
                    $save_image = mysql_query($query_Recordset1, $dmm_db_connection);
	            }
			} elseif ($img_destination == "issue"){
				if($image_usage!="article"){ // if destination = issue but reason NOT = article
                    $query_Recordset1="UPDATE dmm_pub_issues set pub_issue_".$image_usage." = ".GetSQLValueString($file_name.".".$ext, "text")." WHERE pub_issue_id = ".GetSQLValueString($this_data['frm_pub_issue_id'], "int");
				    $save_image = mysql_query($query_Recordset1, $dmm_db_connection);
				} else { //if destination = issue AND reason = article
                    $query_Recordset1="INSERT INTO dmm_issue_article_images (issue_id, article_id, article_image_filename, article_image_caption, article_image_credits, article_image_weight) values (" . GetSQLValueString($this_data['frm_pub_issue_id'], "int"). ", " . GetSQLValueString($this_data['frm_article_id'], "int"). ", ".GetSQLValueString($file_name.".".$ext, "text").", " . GetSQLValueString($this_data['frm_image_caption'], "text"). ", " . GetSQLValueString($this_data['frm_image_copyright'], "text"). ", " . GetSQLValueString($this_data['frm_image_weight'], "int"). ")";
					//echo $query_Recordset1; exit;
					$save_image = mysql_query($query_Recordset1, $dmm_db_connection);
				} 
			} elseif ($img_destination == "article"){ 
                $query_Recordset1="INSERT INTO dmm_article_images (article_image_weight, article_id, article_image_filename, article_image_caption, article_image_credits) 
				                   VALUES (" . GetSQLValueString($this_data['frm_image_weight'], "int") . ", "  . GetSQLValueString($this_data['frm_article_id'], "int") . ", " . GetSQLValueString($file_name.".".$ext, "text") .                                   ", " . GetSQLValueString($this_data['frm_image_caption'], "text") . ", " . GetSQLValueString($this_data['frm_image_copyright'], "text") . " )";
				$save_image = mysql_query($query_Recordset1, $dmm_db_connection);
			}
			
            return $return;			
		}
    } catch (RuntimeException $e) {
        return $e->getMessage(); 
    }
}


function save_this_article($the_data, $user_id){
    if($the_data['frm_article_deadline']){
		$this_date = explode('-', $the_data['frm_article_deadline']);
		$savedate = checkdate($this_date[1],$this_date[0],$this_date[2]) ? $this_date[2]."-".$this_date[1]."-".$this_date[0] : "";
	}
    global $dmm_db_connection;
	$return=0;
	if($the_data['frm_article_id']!="new"){
        if(isset($the_data['frm_article_pub']) and $the_data['frm_article_pub']){
            $spontaneus = ", article_spontaneous = " . GetSQLValueString($the_data['frm_article_pub'], "int"); 
        }
		$resp = save_article_last_version($the_data['frm_article_id']);
        $query_Recordset1 = "UPDATE dmm_articles SET article_title = " . GetSQLValueString($the_data['frm_article_title'], "text")  . ", article_subtitle=" . GetSQLValueString($the_data['frm_article_subtitle'], "text") . ", article_body=" . GetSQLValueString($the_data['frm_article_body'], "text") . ", article_slug=" . GetSQLValueString(Slugfy($the_data['frm_article_title'], "'"), "text") . (isset($the_data['frm_article_ready']) ? ", article_ready=1 ": ", article_ready=0") . ", article_version_id=article_version_id+1" . $spontaneus . " WHERE article_id=" . GetSQLValueString($the_data['frm_article_id'], "int") . " and article_author_id=" . GetSQLValueString($user_id, "int") ." and isnull(article_pub_tstamp)" ; 
	} else { 
        if(isset($the_data['frm_article_pub']) and $the_data['frm_article_pub']){
            $spontaneus1 = ", article_spontaneous ";
			$spontaneus2 = ", " . GetSQLValueString($the_data['frm_article_pub'], "int");
        }
	    $query_Recordset1 = "INSERT INTO dmm_articles (article_author_id, article_pub_pauta, article_pub_issue_id, article_title, article_subtitle, article_body, article_slug, article_ready, article_deadline". $spontaneus1 . ") VALUES (" . GetSQLValueString($user_id, "int") . ", " . GetSQLValueString($the_data['frm_article_pub_pauta'], "int") . ", " . GetSQLValueString($the_data['frm_article_pub_issue_id'], "int") . ", " . GetSQLValueString($the_data['frm_article_title'], "text") . ", " . GetSQLValueString($the_data['frm_article_subtitle'], "text") . ", " . GetSQLValueString($the_data['frm_article_body'], "text") . ", " . GetSQLValueString(Slugfy($the_data['frm_article_title'], "'"), "text") . (isset($the_data['frm_article_ready']) ? ", 1 ": ", 0") . ", " . GetSQLValueString($savedate, "text") . $spontaneus2 . ")";	
	}
    if($return = mysql_query($query_Recordset1, $dmm_db_connection)){
	    $return = ($the_data['frm_article_id']=="new") ? mysql_insert_id() : $return;
	}

	return $return;	
}

function save_article_last_version($artid){
    global $dmm_db_connection;
    $return=0;
    $query_Recordset1 = "INSERT INTO dmm_articles_history (article_id, article_version_id, article_author_id, article_pub_issue_id, article_pub_pauta, article_tstamp, article_pub_tstamp, article_title, article_subtitle, article_body, article_slug, article_ready, article_deadline, article_spontaneous) SELECT article_id, article_version_id, article_author_id, article_pub_issue_id, article_pub_pauta, article_tstamp, article_pub_tstamp, article_title, article_subtitle, article_body, article_slug, article_ready, article_deadline, article_spontaneous FROM dmm_articles WHERE article_id = " . GetSQLValueString($artid,"int");
    $return = mysql_query($query_Recordset1, $dmm_db_connection);
    return $return;	
}

function save_this_pub_basic_info($this_pub){
    global $dmm_db_connection;
	$return=0;
	$this_slug = ($this_pub['frm_publication_slug']) ?  GetSQLValueString($this_pub['frm_publication_slug'], "text") : GetSQLValueString(Slugfy($this_pub['frm_publication_name']), "text");
	if($this_pub['frm_pub_id']!="new"){
	    $this_pub_id = GetSQLValueString($this_pub['frm_pub_id'], "int");
        $return = save_old_pub_details($this_pub['frm_pub_id'], "basic");
	    $query_Recordset1 = "update dmm_pubs set pub_country=" . GetSQLValueString($this_pub['country'], "text") . ", pub_language=" . GetSQLValueString($this_pub['language'], "text") . ", pub_name=" . GetSQLValueString($this_pub['frm_publication_name'], "text") . ", pub_mote=" . GetSQLValueString($this_pub['frm_publication_mote'], "text") . ", pub_slug=" . $this_slug . " WHERE pub_id = " . $this_pub_id;
	} else {
        $query_Recordset1 = "insert into dmm_pubs (pub_country, pub_language, user_id, pub_name, pub_mote, pub_slug, pub_type, pub_income_status, pub_style) values (" . GetSQLValueString($this_pub['country'], "text") . ", " . GetSQLValueString($this_pub['language'], "text") . ", " . GetSQLValueString($_SESSION['user_id'], "int") . ", " . GetSQLValueString($this_pub['frm_publication_name'], "text") . ", " . GetSQLValueString($this_pub['frm_publication_mote'], "text") . ", " . $this_slug . ", " . GetSQLValueString($this_pub['frm_publication_type'], "int") . ", " . GetSQLValueString($this_pub['frm_publication_income'], "int") . ", " . GetSQLValueString($this_pub['frm_publication_style'], "int") . ")";
	}
    if(mysql_query($query_Recordset1, $dmm_db_connection)){
        if($this_pub['frm_pub_id']=="new") {
    		$new_id = mysql_insert_id();
            $query_Recordset1 = "insert into dmm_pub_staff (dmm_pub_id, dmm_user_id) values (" . $new_id . ", " . $_SESSION['user_id'] . ")"; // owner is always added as a contributor
			$return = (mysql_query($query_Recordset1, $dmm_db_connection)) ? $new_id : $return ;
			if($this_pub['frm_publication_style']==2) { // if pub style = 'news feed' then there will be no issues (1, 2, 3....) but an 'implicit' issue 0 (Zero).
                $query_Recordset1 = "insert into dmm_pub_issues (pub_id, pub_issue) values (" . $new_id . ", 0)";
			    $return = (mysql_query($query_Recordset1, $dmm_db_connection)) ? $new_id : $return ;
		    }
		}
    };
    return $return;	
}


function save_old_pub_details($this_pub_id, $reason){
    global $dmm_db_connection;
	$return=0;
    $SQL_next = "select IFNULL(max(pub_id_history)+1, 1) as next from dmm_pubs_history where pub_id=" . GetSQLValueString($this_pub_id, "int");
	if($next = mysql_query($SQL_next, $dmm_db_connection)){
		$next_id = mysql_fetch_assoc($next);
        $query_Recordset1 = "INSERT INTO dmm_pubs_history (pub_id, pub_id_history, pub_country, user_id, pub_language, pub_name, pub_mote, pub_slug, pub_css, pub_logo, reason) SELECT p.pub_id, " . $next_id['next'] . ", p.pub_country, p.user_id, p.pub_language, p.pub_name, p.pub_mote, p.pub_slug, p.pub_css, p.pub_logo, '" . $reason . "' from dmm_pubs p where p.pub_id = " . GetSQLValueString($this_pub_id, "int");
	    $return = mysql_query($query_Recordset1, $dmm_db_connection);
	}
    return $return;	
}

function save_pub_old_sections($this_pub_id, $reason="add"){
    global $dmm_db_connection;
	$return=0;
    $SQL_next = "select IFNULL(max(section_id_history)+1, 1) as next from dmm_pub_sections_template_history where pub_id=" . GetSQLValueString($this_pub_id, "int");
	if($next = mysql_query($SQL_next, $dmm_db_connection)){
		$next_id = mysql_fetch_assoc($next);
        $query_Recordset1 = "INSERT INTO dmm_pub_sections_template_history (pub_id, section_id, section_id_history, section_weight, section_name, section_order, reason) SELECT ps.pub_id, section_id, " . $next_id['next'] . ", ps.section_weight, ps.section_name, ps.section_order, " . GetSQLValueString($reason, "text") . " from dmm_pub_sections_template ps where ps.pub_id = " . GetSQLValueString($this_pub_id, "int");
        $return = mysql_query($query_Recordset1, $dmm_db_connection);
    }
    return $return;	
}

function save_pub_old_staff($this_pub_id, $user_id){
    global $dmm_db_connection;
	$return=0;
    $query_Recordset1 = "INSERT INTO dmm_pub_staff_history (dmm_pub_id, dmm_user_id, dmm_staff_tstamp) SELECT s.dmm_pub_id, s.dmm_user_id, s.dmm_staff_tstamp from dmm_pub_staff s where s.dmm_pub_id = " . GetSQLValueString($this_pub_id, "int") . " AND s.dmm_user_id = " . GetSQLValueString($user_id, "int");
        $return = mysql_query($query_Recordset1, $dmm_db_connection);
    return $return;	
}

function save_issue_old_column($column_id){
    global $dmm_db_connection;
	$return=0;
    $query_Recordset1 = "INSERT INTO dmm_pub_columns_template_history (column_id, pub_id, section_id, user_id, column_name, pub_columns_tstamp) SELECT c.column_id, c.pub_id, c.section_id, c.user_id, c.column_name, 
	                     c.pub_columns_tstamp from dmm_pub_columns_template c where c.column_id = " . GetSQLValueString($column_id, "int");
    $return = mysql_query($query_Recordset1, $dmm_db_connection);
    return $return;	
	
}

function save_issue_old_sections($this_pub_issue_id, $reason="add"){
    global $dmm_db_connection;
	$return=0;
    $SQL_next = "select IFNULL(max(section_id_history)+1, 1) as next from dmm_pub_issue_sections_history where pub_issue_id=" . GetSQLValueString($this_pub_issue_id, "int");
	if($next = mysql_query($SQL_next, $dmm_db_connection)){
		$next_id = mysql_fetch_assoc($next);
		$query_Recordset1 = "INSERT INTO dmm_pub_issue_sections_history (pub_issue_id, section_id, section_id_history, section_weight, section_name, section_order, reason) SELECT pis.pub_issue_id, section_id, " . $next_id['next'] . ", pis.section_weight, pis.section_name, pis.section_order, " . GetSQLValueString($reason, "text") . " from dmm_pub_issue_sections pis where pis.pub_issue_id = " . GetSQLValueString($this_pub_issue_id, "int");
		//echo $query_Recordset1; exit;
		$return = mysql_query($query_Recordset1, $dmm_db_connection);
    }
    return $return;	
}

function save_old_issue_css($this_pub_issue_id){
    global $dmm_db_connection;
	$return=0;
    $SQL_next = "select IFNULL(max(pub_issue_id_history)+1, 1) as next from dmm_pub_issue_css_history where pub_issue_id=" . GetSQLValueString($this_pub_issue_id, "int");
	if($next = mysql_query($SQL_next, $dmm_db_connection)){
		$next_id = mysql_fetch_assoc($next);
		$query_Recordset1 = "INSERT INTO dmm_pub_issue_css_history (pub_issue_id, pub_issue_id_history, pub_issue_css) SELECT pic.pub_issue_id, " . $next_id['next'] . ", pic.pub_issue_css from dmm_pub_issue_css pic where pic.pub_issue_id = " . GetSQLValueString($this_pub_issue_id, "int");
		//echo $query_Recordset1; exit;
		$return = mysql_query($query_Recordset1, $dmm_db_connection);
    }
    return $return;	

	
}

function create_new_issue($pub_id){ /* ATTENTION... So far no error treatment */
    global $dmm_db_connection;
	$return=0;
    $query_Recordset1 = "INSERT INTO dmm_pub_issues (pub_id, pub_issue, pub_issue_logo) SELECT " . GetSQLValueString($pub_id, "int") . ", IFNULL((Max(pp.pub_issue) + 1),1), (select dmm_pubs.pub_logo from dmm_pubs where dmm_pubs.pub_id = " . GetSQLValueString($pub_id, "int") . ") FROM dmm_pub_issues pp WHERE pp.pub_id = " . GetSQLValueString($pub_id, "int") . "";
    $return = mysql_query($query_Recordset1, $dmm_db_connection);
    $new_id = mysql_insert_id();
	$query_Recordset1 = "INSERT INTO dmm_pub_issue_css (pub_issue_id, pub_issue_css) SELECT " . GetSQLValueString($new_id, "int") . ", dmm_pubs.pub_css FROM dmm_pubs WHERE dmm_pubs.pub_id=" . GetSQLValueString($pub_id, "int");
	$return = mysql_query($query_Recordset1, $dmm_db_connection);
	$query_Recordset1 = "INSERT INTO dmm_pub_issue_sections (pub_issue_id, section_id, section_weight, section_name, section_order) SELECT " . GetSQLValueString($new_id, "int") . ", section_id, section_weight, section_name, section_order FROM dmm_pub_sections_template WHERE dmm_pub_sections_template.pub_id=" . GetSQLValueString($pub_id, "int");
	$return = mysql_query($query_Recordset1, $dmm_db_connection);
	
	/* ATTENTION 
       Insert into articles....
	   based on columns defined in the template dmm_pub_columns_template
	       column_id   - unique PK on the table
		   pub_id      - the publications of this issue
		   section_id  - the section within the issue where the column belongs
		   user_id     - the author to whom the column (article) is designated (so to appear on his articles lists)
           column_name -  the column/article name/title
	   so an article with title = column_name, author = user_id will be created for each Column (article). */
	$the_data=array();
	$temp_array=array();
    $result_set = get_columns_by_pub($pub_id);
	
	reset($result_set);
	foreach ($result_set as $key => $value){
    	//	 Array variables names matching form element names so to match what function expects.
		$user_id = $result_set[$key]['user_id'];
	    $the_data['frm_article_pub_pauta']              =  NULL;
		$the_data['frm_article_pub_issue_id']           =  $new_id;
		$the_data['frm_article_title']                  =  $result_set[$key]['column_name'];
		$the_data['frm_article_subtitle']               =  NULL;
		$the_data['frm_article_body']                   =  NULL;
		$the_data['frm_article_ready']                  =  NULL;
		$the_data['frm_article_deadline']	            =  NULL;
		$the_data['frm_article_id']                     =  "new"; // so to allow creation of new article inside the function
		
        //   Call function - the result is the insert id.
		$new_art_id                                     = save_this_article($the_data, $user_id);
		
		// temp array for including columns in dmm_pub_issue_articles
		$temp_array[$key]['pub_issue_id']               =  GetSQLValueString($new_id, "int");
		$temp_array[$key]['article_id']                 =  GetSQLValueString($new_art_id, "int");
		$temp_array[$key]['section_id']                 =  GetSQLValueString($result_set[$key]['section_id'], "int");
		$temp_array[$key]['user_id']                    =  GetSQLValueString($user_id, "int");		
	}

    reset($temp_array);

    foreach ($temp_array as $key => $value){
        $query_Recordset1 = "INSERT INTO dmm_pub_issue_articles (pub_issue_id, article_id, section_id, user_id, article_weight) values (" . $temp_array[$key]['pub_issue_id'] . "," . 
                             $temp_array[$key]['article_id'] . "," . $temp_array[$key]['section_id'] . "," . $temp_array[$key]['user_id'] . ", 0)";
        $return = mysql_query($query_Recordset1, $dmm_db_connection);
	}

    // ATTENTION... So far no error treatment */
	return $new_id;	
}

function request_article($the_post){	
    global $dmm_db_connection;
	$return=0;
	$user_id                                        =  $the_post['frm_pub_issue_article_author'];
	$the_data['frm_article_pub_pauta']              =  NULL;
	$the_data['frm_article_pub_issue_id']           =  $the_post['frm_pub_issue_id'];
	$the_data['frm_article_title']                  =  $the_post['frm_pub_issue_article'];
	$the_data['frm_article_subtitle']               =  NULL;
	$the_data['frm_article_body']                   =  NULL;
	$the_data['frm_article_ready']                  =  NULL;
	$the_data['frm_article_deadline']	            =  $the_post['frm_pub_issue_deadline'];
	$the_data['frm_article_id']                     =  "new"; // so to allow creation of new article inside the function	

	// Save function - the result is the insert id.
	if($new_art_id = save_this_article($the_data, $user_id)){
	
	// Insert in this issue
	    $query_Recordset1 = "INSERT INTO dmm_pub_issue_articles (pub_issue_id, article_id, section_id, user_id, article_weight) values (" .  GetSQLValueString($the_post['frm_pub_issue_id'], "int") . "," . 
                         GetSQLValueString($new_art_id, "int") . ", " . GetSQLValueString($the_post['frm_pub_issue_article_section'], "int") . "," . GetSQLValueString($user_id, "int") . ", " . GetSQLValueString($the_post['frm_pub_issue_article_weight'], "int") . ")";

        $return = mysql_query($query_Recordset1, $dmm_db_connection);
	}
    return $new_art_id;
}

function update_issue_article_properties($the_post){	
    global $dmm_db_connection;
	$return=0;
	if($the_post['frm_pub_issue_article_id'] and $the_post['frm_pub_issue_id']){
	    $query_Recordset1 = "UPDATE dmm_pub_issue_articles SET section_id=" .  GetSQLValueString($the_post['frm_pub_issue_article_section'], "int") . ", article_weight=" .  GetSQLValueString($the_post['frm_pub_issue_article_weight'], "int") . " WHERE pub_issue_id=" . GetSQLValueString($the_post['frm_pub_issue_id'], "int") . " AND article_id=" . GetSQLValueString($the_post['frm_pub_issue_article_id'], "int") . " AND NOT (Select pub_issue_published FROM dmm_pub_issues WHERE pub_issue_id = " . GetSQLValueString($the_post['frm_pub_issue_id'], "int") . ")"; // not after publishing
        $return = mysql_query($query_Recordset1, $dmm_db_connection);
	}
    return $return;
}

function publish_issue($this_pub_issue_id){
    global $dmm_db_connection;
	$return="";
	$query_Recordset1 = "UPDATE dmm_pub_issues set pub_issue_published=1, pub_issue_tstamp=NOW() where pub_issue_id=" . GetSQLValueString($this_pub_issue_id, "int");
	if( mysql_query($query_Recordset1, $dmm_db_connection)){
	    $query_Recordset1 = "UPDATE dmm_articles set article_pub_tstamp=NOW() where article_pub_issue_id=" . GetSQLValueString($this_pub_issue_id, "int");
		$return = mysql_query($query_Recordset1, $dmm_db_connection);
	    $query_Recordset1 = "Select p.pub_slug from dmm_pubs p inner join dmm_pub_issues pi on p.pub_id = pi.pub_id where pi.pub_issue_id=" . GetSQLValueString($this_pub_issue_id, "int");
		$Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
		if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	    {
	    	$return = $row_Recordset1['pub_slug'];
	    }
	}
	return $return;
}

/*****************************************************************************
 ************                   Delete Functions                  ************ 
 *****************************************************************************/
function discard_article($the_post){
    global $dmm_db_connection;
	$return="";
	$query_Recordset1 = "DELETE FROM dmm_pub_issue_articles WHERE pub_issue_id=" . GetSQLValueString($the_post['frm_pub_issue_id'], "int") . " AND article_id=" . GetSQLValueString($the_post['frm_pub_issue_article_id'], "int") . " AND NOT (Select pub_issue_published FROM dmm_pub_issues WHERE pub_issue_id = " . GetSQLValueString($the_post['frm_pub_issue_id'], "int") . ")";
    $return = mysql_query($query_Recordset1, $dmm_db_connection);
	if($return){
		$query_Recordset1 = "UPDATE dmm_articles set article_pub_issue_id=NULL, article_pub_tstamp=NULL WHERE article_pub_issue_id=" . GetSQLValueString($the_post['frm_pub_issue_id'], "int") . " AND article_id=" . GetSQLValueString($the_post['frm_pub_issue_article_id'], "int") . " AND NOT (Select pub_issue_published FROM dmm_pub_issues WHERE pub_issue_id = " . GetSQLValueString($the_post['frm_pub_issue_id'], "int") . ")";
        $return = mysql_query($query_Recordset1, $dmm_db_connection);
	}
	return $return;
} 

function delete_pub_section_by_pub ($pubid, $sectionid){
    global $dmm_db_connection;
	$return = 0;
	$return = save_pub_old_sections($pubid, "delete");
	$query_Recordset1 = "delete from dmm_pub_sections_template WHERE pub_id = " . GetSQLValueString($pubid, "int") . " and section_id=" . GetSQLValueString($sectionid, "int");
	$return = mysql_query($query_Recordset1, $dmm_db_connection);	
	return $return;			
}

function delete_pub_staff_by_pub_user ($pubid, $userid){
     global $dmm_db_connection;
    $return = 0;
    $return = save_pub_old_staff($pubid, $userid);
   	$query_Recordset1 = "delete from dmm_pub_staff WHERE dmm_pub_id = " . GetSQLValueString($pubid, "int") . " and dmm_user_id=" . GetSQLValueString($userid, "int");
   	$return = mysql_query($query_Recordset1, $dmm_db_connection);
   return $return;			
}

function delete_pub_column_by_column_id($column_id){
    global $dmm_db_connection;
	$return = 0;
	$return = save_issue_old_column($column_id);
	$query_Recordset1 = "delete from dmm_pub_columns_template WHERE column_id = " . GetSQLValueString($column_id, "int") ;
	$return = mysql_query($query_Recordset1, $dmm_db_connection);	
	return $return;				
}

function delete_issue_section_by_issue ($pub_issue_id, $sectionid){
    global $dmm_db_connection;
	$return = 0;
	if (if_not_published($pub_issue_id)){
	    $return = save_issue_old_sections($pub_issue_id, "delete");
	    $query_Recordset1 = "delete from dmm_pub_issue_sections WHERE pub_issue_id = " . GetSQLValueString($pub_issue_id, "int") . " and section_id=" . GetSQLValueString($sectionid, "int");
	    $return = mysql_query($query_Recordset1, $dmm_db_connection);	
	}
	return $return;			
}

/************************* DO Somethihg functions *****************************/

function Slugfy($str, $replace=array(), $delimiter='-') {
    setlocale(LC_ALL, 'en_US.UTF8');
	if( !empty($replace) ) {
		$str = str_replace((array)$replace, ' ', $str);
	}
    $str=str_replace('@', ' at ', $str);
	$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
	$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
	$clean = strtolower(trim($clean, '-'));
	$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
    setlocale(LC_ALL,NULL);
	
	return $clean;
}

function url_get_contents ($response, $remoteip) {
    if (!function_exists('curl_init')){ 
        die('CURL is not installed!');
    }
	$mykey = file_get_contents($_SERVER["DOCUMENT_ROOT"] . '/../data/gcaptcha.txt');
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "https://www.google.com/recaptcha/api/siteverify?secret=". $mykey . "&response=".$response."&remoteip=".$remoteip);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $output = curl_exec($ch);
    curl_close($ch);
    return json_decode($output, true);
}
?>