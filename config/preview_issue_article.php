<?php 
     require_once("../Connections/dmm-db-info.php");
     require_once("clean_all.php");
    /*
     * Script:    Preview Issue Article 
     * Copyright: 2010 - Allan Jardine, 2012 - Chris Wright, 2015 Julio Soares
     * License:   GPL v2 or BSD (3-point)
     */
     
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * Easy set variables
     */
     
    /* Array of database columns which should be read and sent back to DataTables. Use a space where
     * you want to insert a non-database field (for example a counter or static image)
     */
    $aColumns = array( 'article_id', 'article_title', 'article_subtitle', 'article_body', 'article_slug', 'article_ready' );
     
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "article_id";
     
    /* DB table to use */
    $sTable = "dmm_articles";
     
    /* Database connection information */
    $gaSql['user']       = $username_dmm_db_connection;
    $gaSql['password']   = $password_dmm_db_connection;
    $gaSql['db']         = $database_dmm_db_connection;
    $gaSql['server']     = $hostname_dmm_db_connection;
     
     
    /* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
     * If you just want to use the basic configuration for DataTables with PHP server-side, there is
     * no need to edit below this line
     */
     
    /*
     * Local functions
     */
    function fatal_error ( $sErrorMessage = '' )
    {
        header( $_SERVER['SERVER_PROTOCOL'] .' 500 Internal Server Error' );
        die( $sErrorMessage );
    }
     
    /*
     * MySQL connection
     */
    if ( ! $gaSql['link'] = mysql_pconnect( $gaSql['server'], $gaSql['user'], $gaSql['password']  ) )
    {
        fatal_error( 'Could not open connection to server' );
    }
 
    if ( ! mysql_select_db( $gaSql['db'], $gaSql['link'] ) )
    {
        fatal_error( 'Could not select database ' );
    }
     
     
    /*
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
     */
    $sWhere = "";
    if ( isset($_GET['artid']) && $_GET['artid'] != "" )
    {
        $sWhere = "WHERE article_id = ".mysql_real_escape_string( $_GET['artid'] ) . "  ";
    }
	else $sWhere = "WHERE article_id = -3";
     
    
    /*
     * SQL queries
     * Get data to display
     */
    $sQuery = "
        SELECT ".str_replace(" , ", " ", implode(", ", $aColumns))."
        FROM   $sTable
        $sWhere
    ";
	
	//echo $sQuery; exit;
    $rResult = mysql_query( $sQuery, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
     
    /*
     * Output
     */
     
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
		$row  = ($aRow['article_ready']) ? "<h6>Ready for publishing</h6>"  : "<h6>NOT Ready</h6>";
        $row .= "<h2>" . htmlspecialchars($aRow['article_title']) . "</h2>";
        $row .= "<h3>" . htmlspecialchars($aRow['article_subtitle']) . "</h3>";
        $row .= p_tag_this(htmlspecialchars($aRow['article_body']));		 
        $output = $row;
    }
	
     
    echo $output;
	
	/*****************************************************************************
 ************                  Modifier Functions                 ************ 
 *****************************************************************************/

function p_tag_this($input) 
{   
    if ($input){
		$string = preg_replace_callback('#\R+#', 'p_TagsRecursive', $input); 
       // $string = preg_replace('/\n/', '', $string);
        $string = '<p>'.$string.'</p>';
        $result = $string;
    } else {$result = null;}
	
    return $result;
}

function p_TagsRecursive($input)
{
    static $count_p=0;
    $regex = '#\R+#';

    if (is_array($input)) {
        $input = '</hr ></p><div class = "placehold num-' . intval($count_p) . '"></div><p>'.$input[1];
		$count_p++;
    }

    return preg_replace_callback($regex, 'p_TagsRecursive', $input);
}

?>