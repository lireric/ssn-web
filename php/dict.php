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
	$rt = sprintf ("%d",stripslashes ( $_GET["rt"] ));	// result type: 1 - devices types, 2 - SSN commands, 3 -accounts
	$st = sprintf ("%d",stripslashes ( $_GET["st"] ));	// result subtype. Specific for main result type. E.g. for Accounts: st=1 - objects list, st=2 - devices list
	$p = sprintf ("%d",stripslashes ( $_GET["p"] ));	// parent ID for returned dictionary tree. If set p, then rt and st are ignored.
	$dev_str = stripslashes ( $_GET["dev"] );
	$dev_id = sprintf ("%d",$dev_str);			// Device ID. Get full device info. 
	$dtype = sprintf ("%d",($_GET["dtype"]=='')?-1:$_GET["dtype"]);	// Device type. Get full Device_Type metadata. 

	if (!$ssn_acc) {
		$ssn_acc = sprintf ("%d",stripslashes ( $_GET["a"] ));
	}

	$access_data_level = 0;			// to do: make check auth level (1 - only common data, 0 - private data)


// --------------------------------------------------- dev & acc
if ($dev_str != '') {
	$dev_where = '';	
	if ($dev_id > 0) {
		$dev_where = sprintf (" AND dic_devs_detail.dict_value_int = %d", $dev_id);
	}
	$sql = sprintf ("SELECT 
	    dic_devs_detail.id_dict,
	    dic_devs_detail.dict_item_type,
	    dic_devs_detail.dict_value_int,
	    dic_devs_detail.dict_value_int2 as dev_index,
	    dic_devs_detail.dict_value_int3 as property_mode,
	    dic_devs_detail.dict_item_comment as dev_comment,
	    dic_devs_detail.dict_value_string,
	    dic_devs_detail.dict_value_float,
	    dic_dev_type.dict_item_comment as dev_type_comment,
	    dic_dev_type.dict_value_int as dt_code,
	    dic_dev_type.dict_value_string as dt_str,
	    dic_val_type.dict_value_string as vt_str,
	    dic_val_type.dict_value_int as vt_code
	FROM  ssn_dict AS  dic_acc 
	INNER JOIN ssn_dict AS dt 		ON (dt.dict_value_int = 1 AND dt.dict_parent IS NULL)
	INNER JOIN ssn_dict AS dic_our_acc      ON (dic_acc.id_dict = dic_our_acc.dict_parent AND dic_acc.dict_value_int = 3 AND dic_acc.dict_parent IS NULL)
	INNER JOIN ssn_dict AS dic_acc_devs     ON (dic_our_acc.id_dict = dic_acc_devs.dict_parent  AND dic_acc_devs.dict_value_int = 2 )
	INNER JOIN ssn_dict AS dic_devs_detail  ON (dic_acc_devs.id_dict = dic_devs_detail.dict_parent)
	INNER JOIN ssn_dict AS dic_our_dev_type ON (dic_our_dev_type.dict_parent = dic_devs_detail.id_dict)
	INNER JOIN ssn_dict AS dic_dev_type     ON (dic_our_dev_type.dict_value_int = dic_dev_type.dict_value_int AND dic_dev_type.dict_parent = dt.id_dict)
	INNER JOIN ssn_dict AS dic_val_type     ON (dic_our_dev_type.dict_value_int2 = dic_val_type.dict_value_int)
	INNER JOIN ssn_dict AS vt 		ON (vt.dict_value_int = 4 AND vt.dict_parent IS NULL AND vt.id_dict = dic_val_type.dict_parent)
	WHERE dic_devs_detail.dict_is_active = '1' AND dic_devs_detail.dict_is_common >= '%d' %s", $access_data_level, $dev_where);

//printf("\r\nSQL: %s", $sql);
	$result_1 = SSN_DB::sql_exec ( SSN_DB::get_db(), null, $sql);
	printf("[");
	$res_size = count($result_1);
	foreach ($result_1 as $row) {

		echo json_encode(
			array (
				"id"=>$row['id_dict'],
				 "value"=>$row['dict_value_int'],
				 "label"=>$row['dict_value_string'],
				 "dev_comment"=>$row['dev_comment'],
				 "dev_index"=>$row['dev_index'],
				 "property_mode"=>$row['property_mode'],
				 "dt_label"=>$row['dt_str'],
				 "dt_code"=>$row['dt_code'],
				 "dev_type_comment"=>$row['dev_type_comment'],
				 "vt_label"=>$row['vt_str'],
				 "vt_code"=>$row['vt_code'],
				 "scale"=>$row['dict_value_float']
			));
		if ($count++ < $res_size) {
			printf(",");
		}
	}
	printf("]");

} else if ($dtype >= 0) {
// ---------------------------------------------------: dtype
	$dtype_where = $dtype?" AND dict_dev_type_detail.dict_value_int =".$dtype:'';	
	$sql = sprintf ("SELECT 
		dict_dev_type_detail.id_dict,
		dict_dev_type_detail.dict_value_int as dt_code,
		dict_dev_type_detail.dict_value_string as dt_name,
		dict_dev_type_detail.dict_item_comment as dt_comment
	FROM  ssn_dict AS dt
	INNER JOIN ssn_dict AS dict_dev_type_detail	ON (dict_dev_type_detail.dict_parent = dt.id_dict)
	WHERE dt.dict_value_int = 1 AND dt.dict_parent IS NULL AND dict_dev_type_detail.dict_is_active = '1' %s", $dtype_where);

	$result_1 = SSN_DB::sql_exec ( SSN_DB::get_db(), null, $sql);
	printf("[");


	$res_size = count($result_1);
	foreach ($result_1 as $row) {

	$sql2 = sprintf ("SELECT 
		ds_dt.id_dict as id_dict,
		ds_dt.dict_value_string as dev_srv_comment,
		ds_detail.id_dict as id_dict_detail,
		ds_detail.dict_value_int as service_code,
		ds_detail.dict_value_string as service_name,
		ds_detail.dict_item_comment as service_comment,
		ds_dt.dict_value_int2 as p_index
	FROM  ssn_dict 	    AS ds_dt
	INNER JOIN ssn_dict AS ds	 ON (ds_dt.dict_value_int3 = ds.dict_value_int)
	INNER JOIN ssn_dict AS ds_detail ON (ds_detail.dict_parent = ds.id_dict AND ds_detail.dict_value_int = ds_dt.dict_value_int)
	WHERE ds_dt.dict_parent = %d AND ds_dt.dict_value_int3 = 9 AND ds.dict_is_active = '1'", $row['id_dict']);

	$result_2 = SSN_DB::sql_exec ( SSN_DB::get_db(), null, $sql2);
	$services_array = array();
	$services_data_array = array();

	foreach ($result_2 as $row2) {
// get value types for read/write properties:
	  if (($row2['service_code'] == 4) || ($row2['service_code'] == 5)) {
		$sql3 = sprintf ("SELECT 
			vt_detail.id_dict,
			ds_vt.dict_value_float as scale,
			vt_detail.dict_value_int as value_code,
			vt_detail.dict_value_string as value_name,
			vt_detail.dict_item_comment as value_comment
		FROM  ssn_dict 	    AS ds_vt
		INNER JOIN ssn_dict AS vt_detail ON (vt_detail.dict_value_int = ds_vt.dict_value_int)
		INNER JOIN ssn_dict AS vt	 ON (vt.dict_value_int = 4 AND vt.dict_parent IS NULL AND vt.id_dict = vt_detail.dict_parent)
		WHERE ds_vt.dict_parent = %d AND vt_detail.dict_is_active = '1'", $row2['id_dict']);

//printf("\r\nSQL: %s", $sql3);
		$result_3 = SSN_DB::sql_exec ( SSN_DB::get_db(), null, $sql3);
		// awaiting only one record
                $services_data_array = array(
					'id' => $result_3[0]['id_dict'],
					'index' => $row2['p_index'],
					'value_code' => $result_3[0]['value_code'],
					'scale' => $result_3[0]['scale'],
					'value_name' => $result_3[0]['value_name'],
					'value_comment' => $result_3[0]['value_comment']
					);
	  }
	  array_push($services_array, array(
				'id' => $row2['id_dict'],
				'dev_srv_comment' => $row2['dev_srv_comment'],
				'service_code' => $row2['service_code'],
				'service_name'=>$row2['service_name'],
				'service_comment'=>$row2['service_comment'],
				"service_data"=>$services_data_array 
				));
	}
		echo json_encode(
			array (
				"id"=>$row['id_dict'],
				 "dt_code"=>$row['dt_code'],
				 "dt_name"=>$row['dt_name'],
				 "dt_comment"=>$row['dt_comment'],
				 "services"=>$services_array
			));
		if ($count++ < $res_size) {
			printf(",");
		}
	}
	printf("]");

} else

{ if ($p > 0) {	
// ---------------------------------------------------: p
	$sql = sprintf ("SELECT `ssn_dict`.`id_dict`,
	    `ssn_dict`.`dict_parent`,
	    `ssn_dict`.`dict_item_type`,
	    `ssn_dict`.`dict_value_int`,
	    `ssn_dict`.`dict_value_int2`,
	    `ssn_dict`.`dict_value_string`,
	    `ssn_dict`.`dict_value_float`,
	    `ssn_dict`.`dict_item_comment`
	FROM `ssn_dict` WHERE  `ssn_dict`.`dict_is_active` = '1' AND `ssn_dict`.`dict_is_common` >= '%d' AND `ssn_dict`.`dict_parent` = %d", $access_data_level, $p);
} else if ($rt > 0) {
// ---------------------------------------------------: rt & st || rt
	if ($st > 0) {
// ---------------------------------------------------: rt & st
// if set rt & st:
	$sql = sprintf ("SELECT d1.`id_dict`,
	    d1.`dict_parent`,
	    d1.`dict_item_type`,
	    d1.`dict_value_int`,
	    d4.`dict_value_int2`,
	    d1.`dict_value_string`,
	    d1.`dict_value_float`,
	    d1.`dict_item_comment`,
	    d2.`id_dict`,
	    d2.`dict_value_int`,
	    d2.`dict_value_string`,
	    d2.`dict_value_float`,
	    d2.`dict_item_comment`,
	    d4.`id_dict`,
	    d4.`dict_value_int`,
	    d4.`dict_value_string`,
	    d4.`dict_value_float`,
	    d4.`dict_item_comment`
	FROM `ssn_dict` AS d1 INNER JOIN `ssn_dict` AS d2 ON d1.id_dict = d2.dict_parent INNER JOIN `ssn_dict` AS d3 ON d2.id_dict = d3.dict_parent INNER JOIN `ssn_dict` AS d4 ON d3.id_dict = d4.dict_parent 
	WHERE d2.`dict_is_active` = '1' AND d2.`dict_is_common` >= '%d' AND d1.`dict_parent` IS NULL AND d1.`dict_value_int` = %d AND d2.`dict_value_int` = %d AND d3.`dict_value_int` = %d", $access_data_level, $rt, $ssn_acc, $st);
	} else {
// ---------------------------------------------------: rt
// if set only rt:
	$sql = sprintf ("SELECT d1.`id_dict`,
	    d1.`dict_parent`,
	    d1.`dict_item_type`,
	    d1.`dict_value_int`,
	    d1.`dict_value_int2`,
	    d1.`dict_value_string`,
	    d1.`dict_value_float`,
	    d1.`dict_item_comment`,
	    d2.`id_dict`,
	    d2.`dict_value_int`,
	    d2.`dict_value_string`,
	    d2.`dict_value_float`,
	    d2.`dict_item_comment`
	FROM `ssn_dict` AS d1 INNER JOIN `ssn_dict` AS d2 ON d1.id_dict = d2.dict_parent
	WHERE d2.`dict_is_active` = '1' AND d2.`dict_is_common` >= '%d' AND d1.`dict_parent` IS NULL AND d1.`dict_value_int` = %d", $access_data_level, $rt);
	}
}

	$result_1 = SSN_DB::sql_exec ( SSN_DB::get_db(), null, $sql);
//print_r($result_1);

	printf("[");
	$res_size = count($result_1);
//printf("c: %d", $res_size);
	foreach ($result_1 as $row) {

		echo json_encode(array ("value"=>$row['dict_value_int'], "label"=>$row['dict_value_string'], "opt"=>$row['dict_value_float']));
		if ($count++ < $res_size) {
			printf(",");
		}
	}
	printf("]");
//	echo json_encode($result_1);
}
} // get
?>

