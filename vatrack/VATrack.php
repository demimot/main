<?php

/***********************************************************************************
   Visitor Activity Track - storing whole site activity
   BEGIN - JS 29 apr 2011
      Change - JS 02 may 2011 - Change SP call from "Ins_user_activity"
	                            to "Ins_user_activity_today" to start using 
                                daily tables:
                                xperedon.activity_log_YYYYMMDD instead of
                                xperedon.activity_log
								SP "Ins_user_activity" Dropped after tests.
 ***********************************************************************************/
 
 
 /* original SP
 
********************** insert *********************
 
 CREATE DEFINER=`xpappcandoit`@`localhost` PROCEDURE `Ins_user_activity_today`( 
        SP_IP                      varchar(15), 
        SP_VisitorID               int(10), 
        SP_URL                     varchar(255), 
        SP_Request                 text
)
    MODIFIES SQL DATA
    DETERMINISTIC
    COMMENT 'Inserting records into activity_log_yyyymmdd table'
BEGIN
    set @SQL   = concat("INSERT INTO xperedon.activity_log_", date_format( now( ), "%Y%m%d" ), " (IP, user_id, URL, Request)  VALUES ('", SP_IP, "', ", SP_VisitorID, ", '", SP_URL, "', '", SP_Request, "');");
    Prepare STMT from @SQL;
    EXECUTE STMT;
    DEALLOCATE Prepare STMT;
END$$
 
 
 
 */

function VATrack () {
	
    $Filtered = ($_POST?$_POST:$_GET);

    // Filtering sensitive info
    foreach ($Filtered as $key => $value) {   
        if ($key == "cc" and $value != "") { $Filtered[$key] = substr($value, 0, 4) . "-####-####-####"; } 
        if (strpos($key, "password") or strpos($key, "Password") or $key == "password") { $Filtered[$key] = "********"; }
    }

    // open DB (msqli to enable stored procedure calling)
    $TrkDB = mysqli_connect(VATrack_HostName(), VATrack_User_Name(), VATrack_Password(), VATrack_DB_Name());
    
    // Prepare and call Stored Procedure
	$Trk_Sql = "INSERT INTO fdan_demimotcom1.activity_log_" . date("Y_m_d") . " (IP, http_response, user_agent, user_id, URL, Request)  VALUES ('" . $_SERVER['REMOTE_ADDR'] . "', " . http_response_code() . ", '" . mysql_real_escape_string($_SERVER['HTTP_USER_AGENT']) . "', " . (isset($_SESSION['user_id'])?$_SESSION['user_id']:0) . ", '" . mysql_real_escape_string($_SERVER['REQUEST_URI']) . "', '" . base64_encode(serialize($Filtered)) . "')";
    // below the original
	// $Trk_Sql = "Call Ins_user_activity_today ('" . $_SERVER['REMOTE_ADDR'] . "', " . (isset($_SESSION['VisitorID'])?$_SESSION['VisitorID']:0) . ", '"  . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'] . "', '" . base64_encode(serialize($Filtered)) . "')";
    $TrkResults = mysqli_query($TrkDB, $Trk_Sql);
    
    // Clean up (does not need to free results as isn't a result query)
    mysqli_close( $TrkDB );
}

function VATrack_HostName() {
    $host = "fdan.myd.infomaniak.com";
    return $host;
}

function VATrack_DB_Name() {
    $dbname = "fdan_demimotcom1";
	return $dbname;
}

function VATrack_User_Name() {
    $dbname = "fdan_dmmuser";
	return $dbname;
}

function VATrack_Password() {
    $dbname = "sw50z4zwQEvegIpb";
	return $dbname;
}

/***********************************************************************************
   END  - JS 02 may 2011
 ***********************************************************************************/

?>