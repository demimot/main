<?php require($_SERVER["DOCUMENT_ROOT"] . '/Connections/dmm_db_connection.php'); 
	
## Session
If (!isset($session_id)) session_start();

## Setup site defaults 
define("DMM_DEFAULT_LANGUAGE", "pt");
define("DMM_MAX_LOGO_IMG_SIZE", 100000);

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
    switch ($the_POST['frm_submit']) 
    {
        case 1:
            $this_username=GetSQLValueString($the_POST['frm_username'], "text");
            $this_password=GetSQLValueString(sha1("tamarindo" . trim($the_POST['frm_password'])), "text");
		
            /* consider a function to handle all DB access */ 
			global $dmm_db_connection;
            $query_Recordset1 = "SELECT dmm_users.user_id FROM dmm_users WHERE dmm_users.user_username=" . $this_username . " AND dmm_users.user_pwd=" . $this_password;
            $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
            if($row_Recordset1 = mysql_fetch_assoc($Recordset1)){
                /* get user_id only on the session HERE. Query user data further down if session.user_id is true */ 
                $_SESSION['user_id'] = intval($row_Recordset1['user_id']);
                $_return = ($the_POST['called_from']!="/login")?$the_POST['called_from']:"/";	
            }
	        break;
		case 10:
		    if($save_article = save_this_article($the_POST['frm_article_id']))
			{  
				if ($the_POST['frm_article_id']!="new"){
                    $_return = "/edit-article-" . $the_POST['frm_article_id'];
				} else {
				    $_return = "/edit-article-" . $save_article;
				}
			}
			break;
		case 20:
            if($save_pub = save_this_pub_basic_info($the_POST)){
				if($the_POST['frm_publication_id']!="new"){
					$_return = "/admin-pub-" . $the_POST['frm_publication_id'];
				} else {
					$_return = "/admin-pub-" . $save_pub;			 	
				}
				

		    }
			break;
        case 21:
			if($save_css = save_this_pub_css($the_POST)){
				$_return = "/admin-pub-" . $the_POST['frm_publication_id'];
			}
			break;				    
		case 22:
            $save_logo = save_this_pub_logo($the_POST);
			if($save_logo!==UPLOAD_ERR_OK){
				 $_return = "/admin-pub-" . $the_POST['frm_publication_id']. "?message=" . urlencode($save_logo);
	        } else $_return = "/admin-pub-" . $the_POST['frm_publication_id'];
	        break;
		case 23: // add, change or delete sections from pub
		    if($the_POST['frm_section_verb']=="delete"){
				if($delete_section = delete_pub_section_by_pub($the_POST['frm_publication_id'], $the_POST['frm_sections'])){
				    $_return = "/admin-pub-" . $the_POST['frm_publication_id'];
				}
			} elseif($the_POST['frm_section_verb']=="add"){
				if($add_section = add_pub_section_by_pub($the_POST['frm_publication_id'], $the_POST['frm_section_name'], $the_POST['frm_section_order'])){
				    $_return = "/admin-pub-" . $the_POST['frm_publication_id'];
				}
			
			 } else {
                echo "<pre>" ;
			    var_dump($the_POST);
			    echo "</pre>"; exit;
			}
			break;		
		case 24:
            break;
		case 25:
		    if($new_issue = create_new_issue($the_POST['frm_publication_id']))
			{  
                /* 
				   In fact... when the admin issue page is ready
			       we will set the redirection here so once the issue is created
				   we goes straigth to the admins issue properties page
				   
				   */
			    $_return = "/admin-issue-" . $new_issue;
			} else die();
		    break;
		case 26:
		    if($the_POST['unpub_issues']) $_return = "/admin-issue-" . $the_POST['unpub_issues'];
		 
		   /* echo "<pre>" ;
			var_dump($the_POST);
			echo "</pre>"; 
		    exit; */
		
			break;	
        default:      
    }
	
    unset($_POST);
    $_SESSION['form_xss'] = set_form_xss();
    return $_return;
}


/*****************************************************************************
 ************                 Get stuff Functions                 ************ 
 *****************************************************************************/
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

function get_featured($limit = 10)
{
	$return=array();
    global $dmm_db_connection; /* SQL Esta correto !!! mas... featured nao esta definido mesmo ainda... */
    $query_Recordset1 = "SELECT i.pub_id, i.pub_issue_id, i.pub_issue, p.pub_name, p.pub_mote, p.pub_slug, i.pub_issue_cover FROM dmm_pub_issues i inner join dmm_pubs p on i.pub_id = p.pub_id WHERE i.pub_issue_id IN (
SELECT max(pub_issue_id) as pub_issue_id FROM dmm_pub_issues WHERE pub_published group by pub_id) limit " . $limit;
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;
}

function pub_handler($pub)
{
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT i.pub_id, i.pub_issue_id, pub_issue, i.pub_issue_cover, p.pub_name, p.pub_mote, p.pub_slug FROM dmm_pub_issues i inner join dmm_pubs p on i.pub_id = p.pub_id WHERE i.pub_issue_id=" . GetSQLValueString($pub, "int") . " and i.pub_published";
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	{
		$return = $row_Recordset1;
	}else $return=0;
	return $return;	
}

function get_old_issues ($pub_id, $last_issue){
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT i.pub_issue_id, pub_issue, i.pub_issue_cover, p.pub_name, p.pub_slug FROM dmm_pub_issues i inner join dmm_pubs p on i.pub_id = p.pub_id WHERE i.pub_id=" . GetSQLValueString($pub_id, "int") . " and i.pub_issue not in(" . GetSQLValueString($last_issue, "int") . ") and i.pub_published order by i.pub_issue desc"; 
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;	
}


function get_pub_by_slug($slug, $pid=NULL)
{
	$return=array();
    global $dmm_db_connection; 
	if(is_null($pid)){
        $query_Recordset1 = "SELECT i.pub_id, i.pub_issue_id, i.pub_issue, p.pub_name, p.pub_mote, p.pub_slug, i.pub_issue_cover FROM dmm_pub_issues i inner join dmm_pubs p on i.pub_id = p.pub_id WHERE i.pub_issue_id IN (
SELECT max(pub_issue_id) as pub_issue_id
FROM dmm_pub_issues WHERE pub_published group by pub_id) and p.pub_slug=" . GetSQLValueString($slug, "text") . " limit 1";
	} else {
		$query_Recordset1 = "SELECT i.pub_id, i.pub_issue_id, i.pub_issue, p.pub_name, p.pub_mote, p.pub_slug, i.pub_issue_cover FROM dmm_pub_issues i inner join dmm_pubs p on i.pub_id = p.pub_id WHERE i.pub_issue=" . GetSQLValueString($pid, "int") . " and pub_published and p.pub_slug=" . GetSQLValueString($slug, "text") . " limit 1";
	}
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	{
		$return = $row_Recordset1;
	}else $return=0;
	return $return;
}

function get_articles_by_issue($pub_issue)
{
    global $dmm_db_connection;
	$return=array();
    $query_Recordset1 = "SELECT a.article_id, a.article_title, article_subtitle, article_body, (SELECT pp.pub_name FROM dmm_pub_issues pi INNER JOIN dmm_pubs pp ON pi.pub_id = pp.pub_id WHERE pi.pub_issue_id = a.article_pub_issue_id AND a.article_pub_issue_id!=" . GetSQLValueString($pub_issue, "int") . ") as article_source, a.article_pub_issue_id FROM dmm_pub_issue_articles i INNER JOIN dmm_articles a ON i.article_id = a.article_id WHERE i.pub_issue_id=" . GetSQLValueString($pub_issue, "int") . "";
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }

	return $return;	
}

function get_published_articles_by_author($authid){
    global $dmm_db_connection;
	$return=array();
    $query_Recordset1 = "SELECT a.article_id, a.article_title, (SELECT pp.pub_name FROM dmm_pub_issues pi INNER JOIN dmm_pubs pp ON pi.pub_id = pp.pub_id WHERE pi.pub_issue_id = a.article_pub_issue_id) as article_source, a.article_pub_issue_id FROM dmm_articles a WHERE not isnull(a.article_pub_tstamp) and a.article_author_id=" . GetSQLValueString($authid, "int") . " order by a.article_id DESC";
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;	
}

function get_unpublished_articles_by_author($authid){
    global $dmm_db_connection;
	$return=array();
    $query_Recordset1 = "SELECT a.article_id, a.article_title, (SELECT pp.pub_name FROM dmm_pub_issues pi INNER JOIN dmm_pubs pp ON pi.pub_id = pp.pub_id WHERE pi.pub_issue_id = a.article_pub_issue_id) as article_source, a.article_pub_issue_id FROM dmm_articles a WHERE isnull(a.article_pub_tstamp) and a.article_author_id=" . GetSQLValueString($authid, "int") . " order by a.article_id DESC";
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
    $query_Recordset1 = "SELECT `article_image_filename` ,  `article_image_legend` ,  `article_image_credits` FROM  `dmm_article_images` WHERE  `article_id`=" . GetSQLValueString($article_id, "int") ." ORDER BY  `article_image_weight`" ;  
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

function get_pub_issue_css($issue_id)
{
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT issue_css, UNIX_TIMESTAMP(issue_css_tstamp) as issue_css_tstamp FROM dmm_pub_issue_css WHERE issue_id=" . GetSQLValueString($issue_id, "int");
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	{
		$return = $row_Recordset1;
	}else $return="";
	
	return $return;		
}


function get_article_by_id($artid, $public=0) {
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT * FROM dmm_articles WHERE article_id=" . GetSQLValueString($artid, "int") ; 
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
	}else $return="";
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
    $query_Recordset1 = "SELECT section_id, section_weight, section_name, section_order FROM dmm_pub_issue_sections WHERE pub_issue_id=" . GetSQLValueString($pubid, "int");
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;		
}

function get_issues_by_pub($pubid, $published=0) {
    global $dmm_db_connection;
	$return=array();
    $query_Recordset1 = "SELECT pi.pub_issue, pi.pub_issue_id, p.pub_name, p.pub_name FROM dmm_pub_issues AS pi INNER JOIN dmm_pubs AS p ON pi.pub_id = p.pub_id WHERE pi.pub_id = " . GetSQLValueString($pubid, "int") . " AND pi.pub_published = " . GetSQLValueString($published, "int") . " AND p.user_id = " . GetSQLValueString($_SESSION['user_id'], "int") . " ORDER BY pi.pub_issue_id DESC";
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;		
}

function get_this_issue_data($piid) {
    global $dmm_db_connection;
	$return=0;
    $query_Recordset1 = "SELECT pi.pub_issue, pi.pub_issue_id, p.pub_name, pi.pub_issue_cover, pi.pub_issue_logo FROM dmm_pub_issues AS pi INNER JOIN dmm_pubs AS p ON pi.pub_id = p.pub_id WHERE pi.pub_issue_id = " . GetSQLValueString($piid, "int") . " AND p.user_id = " . GetSQLValueString($_SESSION['user_id'], "int");
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	if($row_Recordset1 = mysql_fetch_assoc($Recordset1)) $return = $row_Recordset1;

    if ($this_css = get_pub_issue_css($piid, $this_css)) $return['issue_css']=$this_css['issue_css'];	
		
	if ($this_sections = get_sections_by_issue($piid) and $this_sections){
		$return['issue_sections'] = array();
	    $return['issue_sections'] = $this_sections;	
	}
	
	if($this_articles = get_articles_by_issue($piid)){
		$return['issue_articles'] = array();
	    $return['issue_articles'] = $this_articles;
	}
	
	
	/* get this issue articles */
	
	return $return;		
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



/*****************************************************************************
 ************              Insert / update Functions              ************ 
 *****************************************************************************/

function add_pub_section_by_pub($pub_id, $section_name, $section_order=0){
    $return=0; 
	if (trim($section_name)!=""){
        global $dmm_db_connection;
	    // get next Section ID value (even if there are "holes" in the sequence"
    	if($return = save_pub_old_sections($pub_id)){
		    $query_Recordset1 = "insert into dmm_pub_sections_template (pub_id, section_id, section_name, section_order) SELECT  " . GetSQLValueString($pub_id, "int") . ", (max(ps.section_id) + 1), " . GetSQLValueString($section_name, "text") . ", "   . GetSQLValueString($section_order, "int") . " FROM dmm_pub_sections_template ps WHERE ps.pub_id = " . GetSQLValueString($pub_id, "int");
		
    	    $return = mysql_query($query_Recordset1, $dmm_db_connection);
	    }
	}
	return $return;	
}

function save_this_pub_css($this_pub){
    global $dmm_db_connection;
	$return=0;
    if($return = save_old_pub_details($this_pub['frm_publication_id'], "css")){
		$query_Recordset1 = "update dmm_pubs set pub_css=" . GetSQLValueString($_POST['frm_publication_css'], "text") . " WHERE pub_id = " . GetSQLValueString($this_pub['frm_publication_id'], "int");
        $return = mysql_query($query_Recordset1, $dmm_db_connection);
	}
    return $return;
}

function save_this_pub_logo ($this_pub)
{
    global $dmm_db_connection;
	$return="";
	
    try {
        // Undefined | Multiple Files | $_FILES Corruption Attack
        // If this request falls under any of them, treat it invalid.
        if ( !isset($_FILES['frm_publication_logo']['error']) ||  is_array($_FILES['frm_publication_logo']['error']) ) {
            throw new RuntimeException('Invalid parameters.');
        }

        // Check $_FILES['frm_publication_logo']['error'] value.
		$return=$_FILES['frm_publication_logo']['error'];
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
        if ($_FILES['frm_publication_logo']['size'] > DMM_MAX_LOGO_IMG_SIZE) {
            throw new RuntimeException('Exceeded filesize limit.');
        }

        // DO NOT TRUST $_FILES['frm_publication_logo']['mime'] VALUE !!
        // Check MIME Type by yourself.
        $finfo = new finfo(FILEINFO_MIME_TYPE);
        if (false === $ext = array_search($finfo->file($_FILES['frm_publication_logo']['tmp_name']), array('jpg' => 'image/jpeg', 'png' => 'image/png', 'gif' => 'image/gif',), true)) {
            throw new RuntimeException('Invalid file format.');
        }

        // On this example, obtain safe unique name from its binary data.
		$file_name = sha1_file($_FILES['frm_publication_logo']['tmp_name']);
		if (file_exists(default_image_dir () . $file_name . "." . $ext)){
            throw new RuntimeException('File already exists');			
		}
	    if (!move_uploaded_file($_FILES['frm_publication_logo']['tmp_name'], default_image_dir () . $file_name . "." . $ext)) {
            throw new RuntimeException('Failed to move uploaded file.');
        }
		else {
            if($save_pub = save_old_pub_details($this_pub['frm_publication_id'], "logo")){
        		$query_Recordset1 = "update dmm_pubs set pub_logo=" . GetSQLValueString($file_name . "." . $ext, "text") . " WHERE pub_id = " . GetSQLValueString($this_pub['frm_publication_id'], "int");
                $save_logo = mysql_query($query_Recordset1, $dmm_db_connection);
	        }
            return $return;			
		}
    } catch (RuntimeException $e) {
        return $e->getMessage(); 
    }
}


function save_this_article($artid){
    global $dmm_db_connection;
	$return=0;
	if($artid!="new"){
        $query_Recordset1 = "UPDATE dmm_articles SET article_title = " . GetSQLValueString($_POST['frm_article_title'], "text")  . ", article_subtitle=" . GetSQLValueString($_POST['frm_article_subtitle'], "text") . ", article_body=" . GetSQLValueString($_POST['frm_article_body'], "text") . ", article_slug=" . GetSQLValueString(toAscii($_POST['frm_article_title'], "'"), "text") . (isset($_POST['frm_article_ready']) ? ", article_ready=1 ": ", article_ready=0") . " WHERE article_id=" . GetSQLValueString($artid, "int") . " and article_author_id=" . GetSQLValueString($_SESSION['user_id'], "int") ." and isnull(article_pub_tstamp)" ;
	} else { 
	    $query_Recordset1 = "INSERT INTO dmm_articles (article_author_id, article_pub_pauta, article_pub_issue_id, article_title, article_subtitle, article_body, article_slug, article_ready, article_deadline) VALUES (" . GetSQLValueString($_SESSION['user_id'], "int") . ", " . GetSQLValueString($_POST['frm_article_pub_pauta'], "int") . ", " . GetSQLValueString($_POST['frm_article_pub_issue_id'], "int") . ", " . GetSQLValueString($_POST['frm_article_title'], "text") . ", " . GetSQLValueString($_POST['frm_article_subtitle'], "text") . ", " . GetSQLValueString($_POST['frm_article_body'], "text") . ", " . GetSQLValueString(toAscii($_POST['frm_article_title'], "'"), "text") . (isset($_POST['frm_article_ready']) ? ", 1 ": ", 0") . ", " . GetSQLValueString($_POST['frm_article_deadline'], "int") . ")";	
	}

    if($return = mysql_query($query_Recordset1, $dmm_db_connection)){
	    $return = ($artid=="new") ? mysql_insert_id() : $return;
	}
	return $return;	
}

function save_this_pub_basic_info($this_pub){
    global $dmm_db_connection;
	$return=0;
	if($this_pub['frm_publication_id']!="new"){
	    $this_pub_id = GetSQLValueString($this_pub['frm_publication_id'], "int");
        $return = save_old_pub_details($this_pub['frm_publication_id'], "basic");
	    $query_Recordset1 = "update dmm_pubs set pub_country=" . GetSQLValueString($_POST['country'], "text") . ", pub_language=" . GetSQLValueString($_POST['language'], "text") . ", pub_name=" . GetSQLValueString($_POST['frm_publication_name'], "text") . ", pub_mote=" . GetSQLValueString($_POST['frm_publication_mote'], "text") . ", pub_slug=" . GetSQLValueString($_POST['frm_publication_slug'], "text") . " WHERE pub_id = " . $this_pub_id;
	} else {
        $query_Recordset1 = "insert into dmm_pubs (pub_country, pub_language, user_id, pub_name, pub_mote, pub_slug) values (" . GetSQLValueString($_POST['country'], "text") . ", " . GetSQLValueString($_POST['language'], "text") . ", " . GetSQLValueString($_SESSION['user_id'], "int") . ", " . GetSQLValueString($_POST['frm_publication_name'], "text") . ", " . GetSQLValueString($_POST['frm_publication_mote'], "text") . ", " . GetSQLValueString($_POST['frm_publication_slug'], "text") . ")";

	}

    if($return = mysql_query($query_Recordset1, $dmm_db_connection)){
        $return = ($this_pub['frm_publication_id']=="new") ? mysql_insert_id() : $return;
    };
    return $return;	
}


function save_old_pub_details($this_pub_id, $reason){
    global $dmm_db_connection;
	$return=0;
    $SQL_next = "select max(pub_id_history)+1 as next from dmm_pubs_history where pub_id=" . GetSQLValueString($this_pub_id, "int");
	if($next = mysql_query($SQL_next, $dmm_db_connection)){
		$next_id = mysql_fetch_assoc($next);
		if($next_id['next']){
            $query_Recordset1 = "INSERT INTO dmm_pubs_history (pub_id, pub_id_history, pub_country, user_id, pub_language, pub_name, pub_mote, pub_slug, pub_css, pub_logo, reason) SELECT p.pub_id, " . $next_id['next'] . ", p.pub_country, p.user_id, p.pub_language, p.pub_name, p.pub_mote, p.pub_slug, p.pub_css, p.pub_logo, '" . $reason . "' from dmm_pubs p where p.pub_id = " . GetSQLValueString($this_pub_id, "int");
		} 
		else {
            $query_Recordset1 = "INSERT INTO dmm_pubs_history (pub_id, pub_country, user_id, pub_language, pub_name, pub_mote, pub_slug, pub_css, pub_logo) SELECT p.pub_id, p.pub_country, p.user_id, p.pub_language, p.pub_name,p.pub_mote, p.pub_slug, p.pub_css, p.pub_logo from dmm_pubs p where p.pub_id = " . GetSQLValueString($this_pub_id, "int");
        }
	    $return = mysql_query($query_Recordset1, $dmm_db_connection);
	}
    return $return;	
}

function save_pub_old_sections($this_pub_id, $reason="add"){
    global $dmm_db_connection;
	$return=0;
    $SQL_next = "select max(section_id_history)+1 as next from dmm_pub_sections_template_history where pub_id=" . GetSQLValueString($this_pub_id, "int");
	if($next = mysql_query($SQL_next, $dmm_db_connection)){
		$next_id = mysql_fetch_assoc($next);
		if($next_id['next']){
            $query_Recordset1 = "INSERT INTO dmm_pub_sections_template_history (pub_id, section_id, section_id_history, section_weight, section_name, section_order, reason) SELECT ps.pub_id, section_id, " . $next_id['next'] . ", ps.section_weight, ps.section_name, ps.section_order, " . GetSQLValueString($reason, "text") . " from dmm_pub_sections_template ps where ps.pub_id = " . GetSQLValueString($this_pub_id, "int");
		} 
		else {
            $query_Recordset1 = "INSERT INTO dmm_pub_sections_template_history (pub_id, section_id, section_weight, section_name, section_order, reason) SELECT ps.pub_id, section_id, ps.section_weight, ps.section_name, ps.section_order, " . GetSQLValueString($reason, "text") . "  from dmm_pub_sections_template ps where ps.pub_id = " . GetSQLValueString($this_pub_id, "int");
        }
	    $return = mysql_query($query_Recordset1, $dmm_db_connection);
}
    return $return;	
}

function create_new_issue($pub_id){ /* ATTENTION... So far no error treatment */
    global $dmm_db_connection;
	$return=0;
    $query_Recordset1 = "INSERT INTO dmm_pub_issues (pub_id, pub_issue, pub_issue_logo) SELECT " . GetSQLValueString($pub_id, "int") . ", (Max(pp.pub_issue) + 1), (select dmm_pubs.pub_logo from dmm_pubs where dmm_pubs.pub_id = " . GetSQLValueString($pub_id, "int") . ") FROM dmm_pub_issues pp WHERE pp.pub_id = " . GetSQLValueString($pub_id, "int") . "";
    $return = mysql_query($query_Recordset1, $dmm_db_connection);
    $new_id = mysql_insert_id();
	$query_Recordset1 = "INSERT INTO dmm_pub_issue_css (issue_id, issue_css) SELECT " . GetSQLValueString($new_id, "int") . ", dmm_pubs.pub_css FROM dmm_pubs WHERE dmm_pubs.pub_id=" . GetSQLValueString($pub_id, "int");
	$return = mysql_query($query_Recordset1, $dmm_db_connection);
	$query_Recordset1 = "INSERT INTO dmm_pub_issue_sections (pub_issue_id, section_id, section_weight, section_name, section_order) SELECT " . GetSQLValueString($new_id, "int") . ", section_id, section_weight, section_name, section_order FROM dmm_pub_sections_template WHERE dmm_pub_sections_template.pub_id=" . GetSQLValueString($pub_id, "int");
	$return = mysql_query($query_Recordset1, $dmm_db_connection);
	 /* ATTENTION... So far no error treatment */
	return $new_id;	
}

/*****************************************************************************
 ************                   Delete Functions                  ************ 
 *****************************************************************************/
function delete_pub_section_by_pub ($pubid, $sectionid){
    global $dmm_db_connection;
	$return = 0;
	$return = save_pub_old_sections($pubid, "delete");
	$query_Recordset1 = "delete from dmm_pub_sections_template WHERE pub_id = " . GetSQLValueString($pubid, "int") . " and section_id=" . GetSQLValueString($sectionid, "int");
	$return = mysql_query($query_Recordset1, $dmm_db_connection);	
	return $return;			
}

function toAscii($str, $replace=array(), $delimiter='-') {
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

/*
$count_p = 1;
// not in use... idea to inject images or adds... 
/*function p_tag_this($params) 
{   
    if ($params){		

		$string = preg_replace_callback('/\n(\s*\n)+/', 'parseTagsRecursive', $params);
        $string = preg_replace('/\n/', '', $string);
        $string = '<p>'.$string.'</p>';
        $result = $string;
		echo $result; exit;
    } else {$result = null;}
    return $result;
}

function parseTagsRecursive($input)
{
    global $count_p;
    $regex = '/\n(\s*\n)+/';

    if (is_array($input)) {
        $input = '</p><!--[$placehold' . $count_p . ']--><p>'.$input[1];
		$count_p++;
    }

    return preg_replace_callback($regex, 'parseTagsRecursive', $input);
}*/
/*
class article {
	var $article_id;
	var $pub_issue_id;
	var $pub_id;
	var $titulo;
	var $subtitulo;
	var $body;
	var $photo;
	function article ()
	{
		 global $dmm_db_connection;
		 $this->dmm_db_connection = $dmm_db_connection;
		 $this->article_id=0;
	     $this->pub_issue_id=0;
	     $this->pub_id=0;
		 $this->titulo="";
		 $this->subtitulo="";
		 $this->body="";
		 $this->photo="";
	}
	
	function getArticle($article_id)
	{
	    $query_Recordset1 = "SELECT * from dmm_articles WHERE article_id=" . GetSQLValueString($article_id, "int") . "";

	}
}
*/
?>