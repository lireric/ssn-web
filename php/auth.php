<?php
//include 'AES.php';
require_once 'ssn_db.php';
//include 'token.php';
header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');

error_reporting(E_ALL ^ E_NOTICE);
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);

//$sIV = "ssn2014\0\0\0\0\0\0\0\0\0";

//$http_headers = getallheaders();
//$ssn_acc = sprintf ("%d",$http_headers['ssn-acc']);
//$ssn_obj = sprintf ("%d",$http_headers['ssn-obj']);
//$ssn_base64 = sprintf ("%d",$http_headers['ssn-base64']);
//$ssn_aes128 = sprintf ("%d",$http_headers['ssn-aes128']);
//printf("\r\nSSN_ACC: %d", $ssn_acc);


//$ssn_db = new ssn_db();

$count=1;
if (getenv('REQUEST_METHOD') == 'GET') 
{
	$u = sprintf ("%s", $_GET["u"] );	// user login. to do: make value check
	$p = sprintf ("%s", $_GET["p"] );	// sha2 value of password
	$r = sprintf ("%d", ($_GET["r"]=='true')?1:0 );	// store or not credentials in cookies for next login (true/false -> 1/0)

	if (!$ssn_acc) {
		$ssn_acc = sprintf ("%d",stripslashes ( $_GET["a"] ));
	}

	$access_data_level = 0;			// to do: make check auth level (1 - only common data, 0 - private data)

// --------------------------------------------------- u & p
if (($u != '') || ( $p != '') ) {

	echo json_encode(SSN_DB::db_user_auth ( $u, $p ));
}
} // get
?>

