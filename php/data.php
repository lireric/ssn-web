<?php
require_once 'ssn_conf.php';
require_once 'ssn_db.php';
include 'AES.php';
include 'crc16.php';
include 'token.php';

error_reporting(E_ALL ^ E_NOTICE);
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);

header('Access-Control-Allow-Origin: *');

$sIV = "ssn2014\0\0\0\0\0\0\0\0\0";
//$sIV = "ssn";
$http_headers = getallheaders();
$ssn_acc = sprintf ("%d",$http_headers['ssn-acc']);
$ssn_obj = sprintf ("%d",$http_headers['ssn-obj']);
$ssn_base64 = sprintf ("%d",$http_headers['ssn-base64']);
$ssn_aes128 = sprintf ("%d",$http_headers['ssn-aes128']);
//printf("\r\nSSN_ACC: %d", $ssn_acc);
//$ssn_db = new ssn_db();

$count=0;

if (getenv('REQUEST_METHOD') == 'GET') 
{
	$u = $_GET["u"];
	$p = $_GET["p"];
	$dev = $_GET["dev"];
	$srv = $_GET["srv"];
	$index = $_GET["index"];
	$token = stripslashes ( $_GET["t"] );
	
	if (($u != '') && ($p != '') && ($dev != '') && ($srv != '')) {
// --------------------------------------------------------------------------: u + p + dev + srv + index 		
		header('Content-type: application/json');
		$data_auth = SSN_DB::db_user_auth ( $u, $p );
//		echo "USER_ACC:".$data_auth["acc_id"];
// check user - $data_auth["acc_id"] > 0 => autorisation ok:
		if ($data_auth["acc_id"]) {
			if (SSN_PREFS::ssn_get_app_pref ("ws_data_mode") == "sinc") {
// *******************************************************: process sincronous message	
				$obj_dst = 1;
				$obj_src = 3;
				$message_type = 2;
						
	//		echo '[{"q":"'.$u.'_'.$p.'_'.$dev.'"}]';
	// process services codes:
				switch ($srv) {
					case 5:
	// write property						
						$value = $_GET["value"];
						$msg_data=sprintf("{\"ssn\":{\"v\":1,\"obj\":%u,\"obj_src\":%u,\"cmd\":\"sdv\", \"data\": {\"adev\":%u,\"acmd\":%u,\"aval\":%d}}}", $obj_dst, $obj_src, $dev, $index, $value);
						
						break;
				}
				
			// Create a new socket
			$sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
			
			// Bind the source address
			socket_bind($sock, '0.0.0.0');
			
			// Connect to destination address
			socket_connect($sock, SSN_PREFS::ssn_get_app_pref ("proxy_server"), SSN_PREFS::ssn_get_app_pref ("proxy_port"));
			
			// Write
			
			$len=strlen($msg_data);
			
					
			$crc=crc16($msg_data);
								
			$request = sprintf("===ssn1%04x%04x%02x%04x%s%04x", $obj_dst, $obj_src, $message_type, $len, $msg_data, $crc);
					
//			echo "REQ: ".$request;
			
			socket_write($sock, $request);
			$response = socket_read($sock, 10000);
			$ret_array = explode("\r\n\n", $response); // [0] - headers, [1] - data
//print_r($ret_arr);
			echo $ret_array[1];
			
			// Close
			socket_close($sock);
				
		
			} else {
// *******************************************************: process asincronous message
					
			}
		}
	} else
	if ($ssn_acc && ($token != '')) {
// --------------------------------------------------------------------------: acc + token 		
//printf("\r\nTOKEN: %s", $token);
	$ssn_token = new token($token, $ssn_acc, $sIV);
	$cmd = $ssn_token->getTokenCommand();
//printf("\r\nCMD: %s", $cmd);
        switch ($cmd) {
// codes see in gsm.h:
// #define gsmWSCmdGetCommands		1	// get next control command
            case 1:

        	$sql = sprintf ("SELECT `command`, `command_data`, `id` FROM `ssn_commands` WHERE `account` = %d AND `object` = %d AND `state` = 1 ORDER BY id ASC LIMIT 0, 1", $ssn_token->getTokenAccount(),$ssn_token->getTokenObject());
//		$result_1 = $ssn_db->sql_exec ( $ssn_db->get_db(), null, $sql);
			$result_1 = SSN_DB::sql_exec ( SSN_DB::get_db(), null, $sql);
		
			$ssn_command_id = $result_1[0]['id'];
			$ssn_command = $result_1[0]['command'];
			$ssn_command_data = $result_1[0]['command_data'];
 
        	$sql = sprintf ("SELECT count(*) AS `count` FROM `ssn_commands` WHERE `account` = %d AND `object` = %d AND `state` = 1 AND `id` <> %d", $ssn_token->getTokenAccount(), $ssn_token->getTokenObject(), $ssn_command_id);
			$result_1 = SSN_DB::sql_exec ( SSN_DB::get_db(), null, $sql);
			$ssn_commands_count = $result_1[0]['count'];

			$output = sprintf("\r\n==begin==\r\n%d\r\n%d\r\n%d\r\n%s\r\n==end==\r\n", $ssn_command_id, $ssn_command, $ssn_commands_count, $ssn_command_data);
			printf($output);
			header('Content-Length: '.strlen($output));
			header('Content-Type: text/plain');
        	$sql = sprintf ("UPDATE `ssn_commands` SET `state` = 3 WHERE `id` = %d", $ssn_command_id);
			$result = SSN_DB::sql_execute( SSN_DB::get_db(), null, $sql);

                break;

// #define gsmWSCmdCommitCommand	2	// commit executing command
            case 2:
				$command_commit_id = $ssn_token->getTokenData1();
        		$sql = sprintf ("UPDATE `ssn_commands` SET `state` = 2, `token` = \"%s\" WHERE `id` = %d", $token, $command_commit_id);
//printf("\r\nSQL:%s",$sql);
				$result = SSN_DB::sql_execute(SSN_DB::get_db(), null, $sql);
		// 8 - commited cmd
				printf("\r\n==begin==\r\n%d\r\n%d\r\n%d\r\n\r\n==end==\r\n", $command_commit_id, 8, $ssn_commands_count);
                break;
	}

	}
} else if (getenv('REQUEST_METHOD') == 'POST') 
{

	if ($ssn_acc) {

		$ssn_acc_key = SSN_DB::get_key($ssn_acc);

    	$inputString = file_get_contents("php://input");
//    $pad = 16 - (strlen($inputString) % 16);
//   $inputString = $inputString . str_repeat(chr($pad), $pad);

//printf("\r\nssn_base64: %s ", $ssn_base64);
//printf("\r\nINPUT_STRING: %s ", $inputString);

	if ($ssn_aes128) {
		$aes = new AES($inputString, $ssn_acc_key, 128);
//echo "After decryption: ".$dec."<br/>";
//	$aes->setMode(AES::M_ECB);
		$aes->setMode('cbc');
		$aes->setIV($sIV);
		if ($ssn_base64==0) {
			$jsonString = rtrim($aes->decrypt_bin(),"\x00..\x1F");

		} else {
			$jsonString = rtrim($aes->decrypt(),"\x00..\x1F");
		}
	} else {
		$jsonString = $inputString;
	}
//	$jsonString = substr($jsonString, 0, strpos($jsonString,"\0"));
//printf("\r\nJSON: %s", $jsonString);
	if ($jsonString) 
	{
		$tele_data = json_decode( $jsonString, false );


	   if ($tele_data) {
		foreach ($tele_data->ssn->data->devs as $device) {

//printf ("\r\nDEV: %d, VAL1: %d, VAL2:%d, TIME:%d", $device->dev, $device->val1, $device->val2, $device->updtime);
//printf ("DEV: %s", $tele_data->ssn->data->devs[1]->dev);


			if ($device->dev) {
				$query = sprintf ('INSERT INTO ssn_teledata (`account`, `object`, `sensor`, `index`, `time_send`, `sensor_value`) VALUES (%d,%d,%d,%d,%d,%d)', $ssn_acc, $ssn_obj, $device->dev, $device->i, $device->updtime, $device->val);
				$result = SSN_DB::sql_execute( SSN_DB::get_db(), null, $query);
			}
			$count++;
//printf("%s", $result);

		}
	  }
	}

	printf("\r\n==begin==\r\n%d\r\n0\r\n0\r\n==end==\r\n", $count);

	}
}

?>