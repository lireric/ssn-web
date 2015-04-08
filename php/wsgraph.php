<?php
//include 'AES.php';
include 'ssn_db.php';
//include 'token.php';
header('Content-type: application/json; charset=UTF-8');
header('Access-Control-Allow-Origin: *');

error_reporting(E_ALL ^ E_NOTICE);
define('WP_DEBUG', false);
define('WP_DEBUG_LOG', false);

//$sIV = "ssn2014\0\0\0\0\0\0\0\0\0";

$http_headers = getallheaders();
$ssn_acc = sprintf ("%d",$http_headers['ssn-acc']);
$ssn_obj = sprintf ("%d",$http_headers['ssn-obj']);
$ssn_base64 = sprintf ("%d",$http_headers['ssn-base64']);
$ssn_aes128 = sprintf ("%d",$http_headers['ssn-aes128']);
//printf("\r\nSSN_ACC: %d", $ssn_acc);


//$ssn_db = new ssn_db();

$count=1;
if (getenv('REQUEST_METHOD') == 'GET') 
{

$gb = sprintf ("%d",stripslashes ( $_GET["gb"] ));	// begin period
$ge = sprintf ("%d",stripslashes ( $_GET["ge"] ));	// end period
$devs = sprintf ("%s",stripslashes ( $_GET["dev"] ));	// device ids ('|' delimited)
$inds = sprintf ("%s",stripslashes ( $_GET["ind"] ));	// device ids ('|' delimited)

$devs_array = explode("|", $devs);
//printf("\r\ndevs: %s", $devs);
//print_r($devs_array);

$dev_where = '';
if ($devs != '') {
	$dev_where = sprintf("AND `ssn_teledata`.`sensor` IN (%s)", str_replace("|", ",", $devs));
}
$ind_where = '';
if ($inds != '') {
	$ind_where = sprintf("AND `ssn_teledata`.`index` IN (%s)", str_replace("|", ",", $inds));
}

$headers = array(
  "Cache-Control: no-cache",
  "ssn-acc: 1"
);
$ch = curl_init();
//curl_setopt($ch, CURLOPT_URL, "http://192.168.1.114/ssn/dict.php?rt=3&st=2"); // to do: get it from prefs
curl_setopt($ch, CURLOPT_URL, "http://192.168.1.114/ssn/dict.php?dev=0"); // to do: get it from prefs
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
$dict_data_devs = json_decode(curl_exec($ch));
//print_r($dict_data_devs);


if (($gb > 0) && ($ge > 0)) {	
	$sql = sprintf ("SELECT `ssn_teledata`.`time_store`, `ssn_teledata`.`sensor_value`, `ssn_teledata`.`sensor`
	FROM `ssn`.`ssn_teledata` WHERE  UNIX_TIMESTAMP(`ssn_teledata`.`time_store`) BETWEEN '%d' AND %d  %s", $gb, $ge, $dev_where);
}

//printf("\r\nSQL: %s", $sql);

	printf("[");
// groups info:
	printf("{\"groups\":[");

	$comma = '';
	$last_orient = 'left';
	$orient = array();
	$axis_title = array();
	$axis_title["right"] = "";
	$axis_title["left"] = "";

	foreach ($dict_data_devs as $obj) {

// cache device info into array:
$devices_info[$obj->value] = $obj;

// select only needed devices:
	if (in_array($obj->value,$devs_array) || $devs=='') {
// calculate axis orientation:
		if (!array_key_exists ( $obj->vt_code , $orient)) {
			$orient[$obj->vt_code] = $last_orient;
                        $axis_title[$last_orient] = $axis_title[$last_orient]." ".$obj->vt_label;

			if ($last_orient == 'right') {
				$last_orient = 'left';
			} else {
				$last_orient = 'right';
			}
		} 
		echo $comma.'{"id":'.$obj->value.', "content":"'.$obj->label.'", "options": {"yAxisOrientation": "'.$orient[$obj->vt_code].'"}}';
		$comma = ",";
	}
	}

//print_r($devices_info);

	printf("]},");


// devices data:
	printf("{\"devices\":[");
	$result_1 = SSN_DB::sql_exec ( SSN_DB::get_db(), null, $sql);
	$count=1;

if ($devs!='') {
	$comma = '';
	foreach ($result_1 as $row) {
		$scale = $devices_info[$row['sensor']]->scale;
		if ($scale == 0) {
			$scale = 1;
		}
		echo $comma.'{"x":"'.$row['time_store'].'", "y":'.(($row['sensor_value'])/$scale).', "group": '.$row['sensor'].'}';
		$comma = ",";
	}
}
	printf("]},");
	echo '{"axisses":[{"left_title":"'.$axis_title["left"].'","right_title":"'.$axis_title["right"].'"}]}';

	printf("]");
//	echo json_encode($result_1);
}
?>

