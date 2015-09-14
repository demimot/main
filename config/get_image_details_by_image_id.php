<?php 
     require_once("../Connections/dmm-db-info.php");
     require_once("clean_all.php");
	 session_start();
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
    $aColumns = array('issue_article_image_id', 'article_id', 'article_image_weight', 'article_image_filename', 'article_image_caption', 'article_image_credits');
     
    /* Indexed column (used for fast and accurate table cardinality) */
    $sIndexColumn = "article_image_id";
     
    /* DB table to use */
    $sTable = "dmm_issue_article_images";
     
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
     $static_content = array();
     /* Load static content */
	 $st_query = "SELECT content_name, content_value FROM static_content WHERE template_name='my_issue_article_image_upload_form.tpl' AND content_lang='" . $_SESSION['language'] ."'";
	 $st_result = mysql_query( $st_query, $gaSql['link'] ) or fatal_error( 'MySQL Error: ' . mysql_errno() );
	 while($stRow = mysql_fetch_array( $st_result )){
		 $static_content[$stRow['content_name']]=$stRow['content_value'];
     }
    /*
     * Filtering
     * NOTE this does not match the built-in DataTables filtering which does it
     * word by word on any field. It's possible to do here, but concerned about efficiency
     * on very large tables, and MySQL's regex functionality is very limited
     */
    $sWhere = "";
    if ( isset($_GET['imgid']) && $_GET['imgid'] != "" )
    {
        $sWhere = "WHERE issue_article_image_id = ".mysql_real_escape_string( $_GET['imgid']) . "  ";
    }
	else $sWhere = "WHERE issue_article_image_id = -3";
     
    
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
        $row .= '                 <div class="row">
                 <div class="large-12 columns">
                     <label for="frm_image_caption" class="left">'.htmlspecialchars($static_content['label02']).'</label>
                     <input type="text" name="frm_image_caption" id="frm_image_caption" value="' . htmlspecialchars($aRow['article_image_caption']) . '" placeholder="'.htmlspecialchars($static_content['label10']).'" onchange="set_article_image_update();" />
                </div>
            </div>
            <div class="row">
                <div class="large-6 columns">
                    <label for="frm_image_copyright" class="left">'.htmlspecialchars($static_content['label03']).'</label>
                    <input type="text" name="frm_image_copyright" id="frm_image_copyright" value="' . htmlspecialchars($aRow['article_image_credits']) . '"placeholder="'.htmlspecialchars($static_content['label11']).'" onchange="set_article_image_update();" />
                </div>
            
			    <div class="large-6 columns">
                    <label for="frm_image_weight" class="left">Peso:</label>
                    <select name="frm_image_weight" id="frm_image_weight" onchange="set_article_image_update();">
                        <option value="0" ' . (($aRow['article_image_weight']==0)? ' selected=true ' : '') . '>0 - '.htmlspecialchars($static_content['label06']).'</option> 
                        <option value="1" ' . (($aRow['article_image_weight']==1)? ' selected=true ' : '') . '>1 - '.htmlspecialchars($static_content['label07']).'</option>
                        <option value="2" ' . (($aRow['article_image_weight']==2)? ' selected=true ' : '') . '>2 - '.htmlspecialchars($static_content['label08']).'</option>
                    </select>
					<input type="hidden" id="save-label" name="save-label" value="'.htmlspecialchars($static_content['label04']).'" /> 
					<input type="hidden" id="delete-label" name="delete-label" value="'.htmlspecialchars($static_content['label09']).'" /> 
                </div>
		    </div>';
	}
	
    $output = $row;
	
    echo $output;

?>