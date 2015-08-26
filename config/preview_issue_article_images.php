<?php 
     require_once("../Connections/dmm-db-info.php");
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
    $aColumns = array('article_id', 'article_image_weight', 'article_image_filename', 'article_image_caption', 'article_image_credits');
     
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "article_image_id";
     
    /* DB table to use */
    $sTable = "dmm_article_images";
     
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
    $flag=0; 
    while ( $aRow = mysql_fetch_array( $rResult ) )
    {
        $row .= '<li><a href="img/' . $aRow['article_image_filename'] . '"><img data-caption="' . $aRow['article_image_caption'] . '" src="img/' . $aRow['article_image_filename'] . '"  naked=true height="100" link=false /></a></li>';
        $flag=true;
	}
	
	if($flag){
	    $row  = '<hr/>
		<div class="clearing-assembled"><div><a href="#" class="clearing-close">×</a><div class="visible-img" style="display: none"><img src="data:image/gif;base64,R0lGODlhAQABAAD/ACwAAAAAAQABAAACADs%3D" alt=""><p class="clearing-caption"></p><a href="#" class="clearing-main-prev"><span></span></a><a href="#" class="clearing-main-next"><span></span></a></div><div class="carousel"><ul class="clearing-thumbs small-block-grid-5" data-clearing="">' . $row . '</ul></div></div></div>';
	}
    $output = $row;
	
    echo $output;

?>