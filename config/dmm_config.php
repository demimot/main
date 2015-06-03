<?php require($_SERVER["DOCUMENT_ROOT"] . '/Connections/dmm_db_connection.php'); 

/*	echo "<pre>";
	var_dump($return);
	echo "</pre>";
	exit;
*/
	
## Session
If (!isset($session_id)) session_start();

## Setup site default language
$default_language = "pt";

;
## Database

function default_image_dir (){
	return "img/";
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


## Anti XSS
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
    switch ($the_POST['frm_submit']) 
    {
        case 1:
            $this_username=GetSQLValueString($the_POST['frm_username'], "text");
            $this_password=GetSQLValueString(sha1("tamarindo" . trim($the_POST['frm_password'])), "text");
		
            /* consider a function to handle all DB access */ 
			global $dmm_db_connection;
            $query_Recordset1 = "SELECT dmm_users.user_id FROM dmm_users WHERE dmm_users.user_username=" . $this_username . " AND dmm_users.user_pwd=" . $this_password;
            $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
            $row_Recordset1 = mysql_fetch_assoc($Recordset1);

            /* get user_id only on the session HERE. Query user data further down if session.user_id is true */ 
            $_SESSION['user_id'] = intval($row_Recordset1['user_id']);
			$_return = isset($the_POST['frm_pub']) ? "?pub=" . $the_POST['frm_pub'] : ""; 
			$_return = isset($the_POST['frm_issue']) ? $_return . "&issue=" . $the_POST['frm_issue'] : $_return; 
            $_return = $_return ? $_return : 1;	
	        break;
        default:      
    }
	unset($_POST);
	return $_return;
}

function have_pubs($user_id)
{
	$return=array();
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT p.pub_name as 'Name', p.pub_mote as 'Mote', p.pub_country as 'Country', p.pub_language as 'Language', p.pub_id as 'Pub ID', p.pub_tstamp as 'Creation date' FROM dmm_pubs p inner join dmm_pub_owner o on p.user_id = o.dmm_user_id AND p.pub_id = o.dmm_pub_id WHERE o.dmm_user_id=" . GetSQLValueString($user_id, "int");
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
    $query_Recordset1 = "SELECT i.pub_id, i.pub_issue_id, i.pub_issue, p.pub_name, p.pub_mote, i.pub_issue_cover FROM dmm_pub_issues i inner join dmm_pubs p on i.pub_id = p.pub_id WHERE i.pub_issue_id IN (
SELECT max(pub_issue_id) as pub_issue_id
FROM dmm_pub_issues WHERE pub_published group by pub_id) limit " . $limit;
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
    while($row_Recordset1 = mysql_fetch_array($Recordset1, MYSQL_ASSOC)) {
          $return[]=$row_Recordset1;
    }
	return $return;
}

function pub_handler($pub)
{
    global $dmm_db_connection;
    $query_Recordset1 = "SELECT i.pub_id, i.pub_issue_id, pub_issue, i.pub_issue_cover, p.pub_name, p.pub_mote FROM dmm_pub_issues i inner join dmm_pubs p on i.pub_id = p.pub_id WHERE i.pub_issue_id=" . GetSQLValueString($pub, "int") . " and i.pub_published";
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	{
		$return = $row_Recordset1;
	}else $return=0;
	return $return;	
}

function article_handler($pub_issue)
{
    global $dmm_db_connection;
	$return=array();
    $query_Recordset1 = "SELECT a.article_id, a.article_title, article_subtitle, article_body, (SELECT pp.pub_name FROM dmm_pub_issues pi INNER JOIN dmm_pubs pp ON pi.pub_id = pp.pub_id WHERE pi.pub_issue_id = a.article_pub_issue_id AND a.article_pub_issue_id!=" . GetSQLValueString($pub_issue, "int") . ") as article_source  FROM dmm_pub_issue_articles i INNER JOIN dmm_articles a ON i.article_id = a.article_id WHERE i.pub_issue_id=" . GetSQLValueString($pub_issue, "int") . "";
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
    $query_Recordset1 = "SELECT issue_css FROM dmm_pub_issue_css WHERE issue_id=" . GetSQLValueString($issue_id, "int");
    $Recordset1 = mysql_query($query_Recordset1, $dmm_db_connection) or die(mysql_error());
	if($row_Recordset1 = mysql_fetch_assoc($Recordset1))
	{
		$return = $row_Recordset1;
	}else $return="";
	
	return $return;		
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