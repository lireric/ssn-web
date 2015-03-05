<?php
include 'db_conf.php';

class SSN_DB {

protected  $db;
protected  $db_host;
protected  $db_user;
protected  $db_passwd;

function __construct() {


}

/**
* 
* @return type
*/

public function connect_db() {

	db_vars_init($this);

	$link = mysql_connect($this->db_host, $this->db_user, $this->db_passwd)
	    or die('connection error: ' . mysql_error());
	mysql_select_db($this->db) or die('DB select error');
	return $link;
}

public function get_key($ssn_acc) {
	$sql_acc = sprintf ("SELECT `acc_key` FROM `ssn_accounts` WHERE `acc_id` = %d",$ssn_acc);

//printf("SELECT: %s", $sql_acc);
	$result = mysql_query($sql_acc) or die('Error: ' . mysql_error());
	$result_1 = mysql_fetch_array($result);
	$ssn_acc_key = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";
	$key_from_DB = $result_1['acc_key'];
//	$ssn_acc_key = $result_1['acc_key'];
	for ($i=0; $i<strlen($key_from_DB); $i++)
	{
		$ssn_acc_key[$i]=$key_from_DB[$i];
	}
//substr_replace ( $ssn_acc_key, $result_1['acc_key'], 0, strlen($result_1['acc_key']));
//printf("\r\nkey: %s ", $ssn_acc_key);

	return $ssn_acc_key;
}

public function setVariables($db, $db_host, $db_user, $db_passwd) {
	$this->db = $db;
	$this->db_host = $db_host;
	$this->db_user = $db_user;
	$this->db_passwd = $db_passwd;
    }

}

