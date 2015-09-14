<?php /* original SP
  
 ************create date*******************
 
 REATE DEFINER=`xpappcandoit`@`localhost` PROCEDURE `Create_Activity_Log_Table`()
    MODIFIES SQL DATA
    DETERMINISTIC
    COMMENT 'Inserting records into activity_log table'
BEGIN
    
    SET SQL_MODE='NO_AUTO_VALUE_ON_ZERO';
    
    
    
    set @SQL = concat( 
    "CREATE TABLE IF NOT EXISTS xperedon.activity_log_", date_format( ADDDATE( now( ) , INTERVAL 1 DAY ), "%Y%m%d" ), 
    "(
        `timestamp` timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT 'User activity timestamp',
        `IP` varchar(15) NOT NULL COMMENT 'User IP Address',
        `VisitorID` int(10) NOT NULL default '0' COMMENT 'Foreign Key to Visitors table',
        `URL` varchar(255) NOT NULL COMMENT 'called URL e.g. www.xperedon.com/...',
        `Request` text NOT NULL COMMENT 'Serialized $_REQUEST array data' 
    ) 
    ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Tracking logged user activity within xperedon website';" );

    
  
    Prepare STMT from @SQL;
    EXECUTE STMT;
    DEALLOCATE Prepare STMT;

END$$
 
*/

// it's to run as shell script only (not in infomaniak)
/*
if (!(PHP_SAPI === 'cli'))
{ 
    header("Location: http://www.demimot.com");	
} 
*/
// Set DB
$DBconnection  = mysqli_connect(VATrack_HostName(), VATrack_User_Name(), VATrack_Password(), VATrack_DB_Name());

if ($DBconnection->connect_errno)
{
    fwrite(STDERR, date("Y.m.d:H:i:s - ", time()) .  $DBconnection->connect_errno . ": " . $DBconnection->connect_error);
    exit($DBconnection->connect_errno);
}


// Prepare Stored Procedure String
$SQL_query = 'CREATE TABLE IF NOT EXISTS '. VATrack_DB_Name (). '.activity_log_' . date('Y_m_d', strtotime('+1 day')) . ' (
        tstamp timestamp NOT NULL default CURRENT_TIMESTAMP COMMENT "User activity timestamp",
        IP varchar(15) NOT NULL COMMENT "User IP Address",
        session varchar(40) NOT NULL COMMENT "for improving counting accuracy",
		http_response smallint UNSIGNED NOT NULL DEFAULT 0 COMMENT "HTTP Response Code",
		user_agent varchar(255) NOT NULL COMMENT "User browser",
        user_id int(10) NOT NULL default 0 COMMENT "Foreign Key to dmm_users",
        URL varchar(255) NOT NULL COMMENT "called URL e.g. www.demimot.com/...",
        Request text NOT NULL COMMENT "Serialized $_REQUEST array data" 
    ) 
    ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT="Tracking logged user activity within Demimot website";';

//fwrite(STDOUT, $SQL_query); 
//exit();

if ($CornerResult = $DBconnection->query($SQL_query, MYSQLI_STORE_RESULT)) {
 //   fwrite(STDOUT, "\n" . date("Y.m.d : H:i:s - ", time()) . "Mix table monthly snapshot generated\n" );
  //  fwrite(STDOUT, date("Y.m.d : H:i:s - ", time()) . "Query OK.\n" );
  echo date("Y.m.d : H:i:s - ", time()) . "Query OK.\n";
	while($DBconnection->more_results()) {
		$DBconnection->next_result();                                     // never forget to move t next result or the 'out of synch error' will happen
	}
	unset($SQL_query);
}
else 
{
   // fwrite(STDERR, date("Y.m.d : H:i:s - ", time()) .  $DBconnection->errno . ": " . $DBconnection->error);
    echo date("Y.m.d : H:i:s - ", time()) .  $DBconnection->errno . ": " . $DBconnection->error;
    exit($DBconnection->errno);
}

// Close connection
mysqli_close( $DBconnection );	

/* e-mail me there is files to be checked / transmited */
$to                     = 'julio@demimot.com';
$subject                = date("d-m-Y") . ' - dayly Visitors Activity table created - OK';
$message                = 'Visitors Activity table created: activity_log_' . date('Y_m_d', strtotime('+1 day')) . "\r\n" ;
$headers                = 'From: julio@demimot.com' . "\r\n" .
                          'Reply-To: julio@demimot.com' . "\r\n" .
                          'X-Mailer: PHP/' . phpversion();
mail($to, $subject, $message, $headers);


function VATrack_HostName() {
    $host = "fdan.myd.infomaniak.com";
    return $host;
}

function VATrack_DB_Name() {
    $dbname = "fdan_demimotcom1";
	return $dbname;
}

function VATrack_User_Name() {
    $dbname = "fdan_demimotdba";
	return $dbname;
}

function VATrack_Password() {
    $dbname = "1OtlGiT3Cx1tTMit";
	return $dbname;
}


?>