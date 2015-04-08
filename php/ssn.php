<?php

include 'ssn_conf.php';

header('Content-type: application/json');
header('Access-Control-Allow-Origin: *');


 
/*
 * DataTables example server-side processing script.
 *
 * Please note that this script is intentionally extremely simply to show how
 * server-side processing can be implemented, and probably shouldn't be used as
 * the basis for a large complex system. It is suitable for simple use cases as
 * for learning.
 *
 * See http://datatables.net/usage/server-side for full details on the server-
 * side processing requirements of DataTables.
 *
 * @license MIT - http://datatables.net/license_mit
 */
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * Easy set variables
 */
 
// DB table to use
$table = 'ssn_teledata';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes
$columns = array(
    array( 'db' => 'id', 'dt' => 0 ),
    array( 'db' => 'object', 'dt' => 1 ),
    array( 'db' => 'sensor',  'dt' => 2 ),
    array( 'db' => 'index',   'dt' => 3 ),
    array( 'db' => 'sensor_value',     'dt' => 4 ),
    array(
        'db'        => 'time_send',
        'dt'        => 5,
        'formatter' => function( $d, $row ) {
            return $d;
//            return date( 'Y-m-d H:i:s', $d);
        }
    ),
    array(
        'db'        => 'time_store',
        'dt'        => 6,
        'formatter' => function( $d, $row ) {
            return date( 'U', strtotime($d));
//            return date( 'Y-m-d H:i:s', strtotime($d));
        }
    )
);
 
// SQL server connection information
/*
$sql_details = array(
    'user' => 'ssn',
    'pass' => '123456',
    'db'   => 'ssn',
    'host' => 'localhost'
);
*/ 

$sql_details = SSN_PREFS::get_ssn_prefs_db();
 
/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
 * If you just want to use the basic configuration for DataTables with PHP
 * server-side, there is no need to edit below this line.
 */

require( 'ssp.class.php' );

// get dicts from our REST WS:

// to do: get acc...
        $headers = array(
            "Cache-Control: no-cache",
            "ssn-acc: 1"
        );
       
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "http://192.168.1.114/ssn/dict.php?rt=3&st=2"); // to do: get it from prefs
curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
curl_setopt($ch, CURLOPT_HEADER, false);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$dict_data_devs = curl_exec($ch);
curl_setopt($ch, CURLOPT_URL, "http://192.168.1.114/ssn/dict.php?rt=3&st=1"); // to do: get it from prefs
$dict_data_objs = curl_exec($ch);

curl_close($ch);

	$arr1 = array(
		"yadcf_data_1"    => json_decode($dict_data_objs),
		"yadcf_data_2"    => json_decode($dict_data_devs),
//		"yadcf_data_2"    => array ( array ("value"=>"1001", "label"=>"T1"), array("value"=>"1002", "label"=>"T2"), array("value"=>"1003", "label"=>"T3")),
		"yadcf_data_3"    => array ("0", "1")
	);

//$arr1 = SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns ); 

//echo json_encode($arr1 + SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns ));
echo json_encode($arr1 + SSP::complex( $_GET, $sql_details, $table, $primaryKey, $columns ));

