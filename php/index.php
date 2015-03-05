<?php
include 'AES.php';
include 'ssn_db.php';
include 'token.php';

$sIV = "ssn2014\0\0\0\0\0\0\0\0\0";
//$sIV = "ssn";
$http_headers = getallheaders();
$ssn_acc = sprintf ("%d",$http_headers['ssn-acc']);
$ssn_obj = sprintf ("%d",$http_headers['ssn-obj']);
$ssn_base64 = sprintf ("%d",$http_headers['ssn-base64']);
$ssn_aes128 = sprintf ("%d",$http_headers['ssn-aes128']);
//printf("\r\nSSN_ACC: %d", $ssn_acc);
$ssn_db = new ssn_db();

$count=0;
if (getenv('REQUEST_METHOD') == 'GET') 
{
	if ($ssn_acc) {
	$token = stripslashes ( $_GET["t"] );
//printf("\r\nTOKEN: %s", $token);
	$ssn_token = new token($token, $ssn_acc, $sIV);
	$cmd = $ssn_token->getTokenCommand();
//printf("\r\nCMD: %s", $cmd);
        switch ($cmd) {
// codes see in gsm.h:
// #define gsmWSCmdGetCommands		1	// get next control command
            case 1:
		$link = $ssn_db->connect_db();
        	$sql = sprintf ("SELECT `command`, `command_data`, `id` FROM `ssn_commands` WHERE `account` = %d AND `object` = %d AND `state` = 1 ORDER BY id ASC LIMIT 0, 1", $ssn_token->getTokenAccount(),$ssn_token->getTokenObject());
		$result = mysql_query($sql) or die('Error: ' . mysql_error());
		$result_1 = mysql_fetch_array($result);
		$ssn_command_id = $result_1['id'];
		$ssn_command = $result_1['command'];
		$ssn_command_data = $result_1['command_data'];
        	$sql = sprintf ("SELECT count(*) AS `count` FROM `ssn_commands` WHERE `account` = %d AND `object` = %d AND `state` = 1 AND `id` <> %d", $ssn_token->getTokenAccount(), $ssn_token->getTokenObject(), $ssn_command_id);
		$result = mysql_query($sql) or die('Error: ' . mysql_error());
		$result_1 = mysql_fetch_array($result);
		$ssn_commands_count = $result_1['count'];

		$output = sprintf("\r\n==begin==\r\n%d\r\n%d\r\n%d\r\n%s\r\n==end==\r\n", $ssn_command_id, $ssn_command, $ssn_commands_count, $ssn_command_data);
		printf($output);
		header('Content-Length: '.strlen($output));
		header('Content-Type: text/plain');
        	$sql = sprintf ("UPDATE `ssn_commands` SET `state` = 3 WHERE `id` = %d", $ssn_command_id);
		$result = mysql_query($sql) or die('Error: ' . mysql_error());

                break;

            case 2:
		$command_commit_id = $ssn_token->getTokenData1();
		$link = $ssn_db->connect_db();
        	$sql = sprintf ("UPDATE `ssn_commands` SET `state` = 2, `token` = \"%s\" WHERE `id` = %d", $token, $command_commit_id);
//printf("\r\nSQL:%s",$sql);
		$result = mysql_query($sql) or die('Error: ' . mysql_error());
		// 8 - commited cmd
		printf("\r\n==begin==\r\n%d\r\n%d\r\n%d\r\n\r\n==end==\r\n", $command_commit_id, 8, $ssn_commands_count);
                break;
	}

	}
} else if (getenv('REQUEST_METHOD') == 'POST') 
{

	if ($ssn_acc) {

	$link = $ssn_db->connect_db();
	$ssn_acc_key = $ssn_db->get_key($ssn_acc);

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
printf("\r\nJSON: %s", $jsonString);
	if ($jsonString) 
	{
		$tele_data = json_decode( $jsonString, false );



		foreach ($tele_data->ssn->data->devs as $device) {

//printf ("\r\nDEV: %d, VAL1: %d, VAL2:%d, TIME:%d", $device->dev, $device->val1, $device->val2, $device->updtime);
//    echo "ключ/значение: [$key -> $val]\n\n";
//printf ("DEV: %s", $tele_data->ssn->data->devs[1]->dev);


// Выполняем SQL-запрос
//$query = 'SELECT * FROM test';
//		for ($index=0; $index<=$device->n; $index++) {
			$query = sprintf ('INSERT INTO ssn_teledata (`account`, `object`, `sensor`, `index`, `time_send`, `sensor_value`) VALUES (%d,%d,%d,%d,%d,%d)', $ssn_acc, $ssn_obj, $device->dev, $device->i, $device->updtime, $device->val);
			$result = mysql_query($query) or die('Error: ' . mysql_error());

			$count++;
//		}
//printf("%s", $result);

		}
	}

	printf("\r\n==begin==\r\n%d\r\n0\r\n0\r\n==end==\r\n", $count);
// Освобождаем память от результата
//mysql_free_result($result);

	mysql_close($link);
	}
}

?>