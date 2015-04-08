<?php
require_once 'ssn_conf.php';

class SSN_DB {

static  $db;

static $sql_details;

function __construct() {

}

/**
* 
* @return type
*/

/**
 * Connect to the database
 *
 * @param  array $sql_details SQL server connection details array, with the
 *   properties:
 *     * host - host name
 *     * db   - database name
 *     * user - user name
 *     * pass - user password
 * @return resource Database connection handle
 */
static function sql_connect ( $sql_details )
{
	try {
		$db = @new PDO(
			"mysql:host={$sql_details['host']};dbname={$sql_details['db']}",
			$sql_details['user'],
			$sql_details['pass'],
			array( PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION )
		);
	}
	catch (PDOException $e) {
		self::fatal(
			"An error occurred while connecting to the database. ".
			"The error reported by the server was: ".$e->getMessage()
		);
	}

	return $db;
}

static function connect_db() {

	self::$sql_details = SSN_PREFS::get_ssn_prefs_db();
	self::$db = self::sql_connect ( self::$sql_details );
/*	$this->sql_details = SSN_PREFS::get_ssn_prefs_db();
	$this->db = $this->sql_connect ( $this->sql_details );
*/	
}


/*
static function sql_execute ( $db, $bindings=null, $sql=null )
{
}
*/
/**
 * Execute an SQL query on the database (common)
 *
*/
static function sql_execute ( $db, $bindings=null, $sql=null )
{
	// Argument shifting
	if ( $sql === null ) {
		$sql = $bindings;
	}

	$stmt = $db->prepare( $sql );
	//echo $sql;

	// Bind parameters
	if ( is_array( $bindings ) ) {
		for ( $i=0, $ien=count($bindings) ; $i<$ien ; $i++ ) {
			$binding = $bindings[$i];
			$stmt->bindValue( $binding['key'], $binding['val'], $binding['type'] );
		}
	}

	// Execute
	try {
		$stmt->execute();
	}
	catch (PDOException $e) {
		printf( "An SQL error occurred: ".$e->getMessage() );
	}

	// Return statement
	return  $stmt; 
}

/**
 * Execute an SQL query on the database
 *
 * @param  resource $db  Database handler
 * @param  array    $bindings Array of PDO binding values from bind() to be
 *   used for safely escaping strings. Note that this can be given as the
 *   SQL query string if no bindings are required.
 * @param  string   $sql SQL query to execute.
 * @return array         Result from the query (all rows)
 */
static function sql_exec ( $db, $bindings=null, $sql=null )
{
	$stmt = self::sql_execute ( $db, $bindings, $sql );
	// Return all
	return  $stmt->fetchAll(); 
}

/**
 * Create a PDO binding key which can be used for escaping variables safely
 * when executing a query with sql_exec()
 *
 * @param  array &$a    Array of bindings
 * @param  *      $val  Value to bind
 * @param  int    $type PDO field type
 * @return string       Bound key to be used in the SQL where this parameter
 *   would be used.
 */
static function bind ( &$a, $val, $type )
{
		$key = ':binding_'.count( $a );

		$a[] = array(
			'key' => $key,
			'val' => $val,
			'type' => $type
		);

		return $key;
}

// ****************************************************************************
	/* * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
	 * Internal methods
	 */

	/**
	 * Throw a fatal error.
	 *
	 * This writes out an error message in a JSON string which DataTables will
	 * see and show to the user in the browser.
	 *
	 * @param  string $msg Message to send to the client
	 */
	static function fatal ( $msg )
	{
		echo json_encode( array( 
			"error" => $msg
		) );

		exit(0);
	}

// *****************************************************************************************
/*
public function get_db() {

	if ($this->db === null) {
		$this->connect_db();
	}
	return $this->db;
}
*/
static function get_db() {

	if (self::$db === null) {
		self::connect_db();
	}
	return self::$db;
}

// *****************************************************************************************: get_key
static function get_key($ssn_acc) {

	$sql_acc = sprintf ("SELECT `acc_key` FROM `ssn_accounts` WHERE `acc_id` = %d",$ssn_acc);

	$ssn_acc_key = "\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0\0";

	$result_1 = self::sql_exec(self::get_db(), null, $sql_acc);
//print_r($result_1);
	$key_from_DB = $result_1[0]['acc_key'];
//printf("\r\nkey from db: %s ", $key_from_DB);
	for ($i=0; $i<strlen($key_from_DB); $i++)
	{
		$ssn_acc_key[$i]=$key_from_DB[$i];
	}
//substr_replace ( $ssn_acc_key, $result_1['acc_key'], 0, strlen($result_1['acc_key']));
//printf("\r\nkey__: %s ", $ssn_acc_key);

	return $ssn_acc_key;
}

// *****************************************************************************************: db_user_auth
static function db_user_auth ( $user_login, $user_password )
{
	$sql = sprintf ("SELECT
	    a.acc_id,
	    u.user_id,
	    u.user_login,
	    u.user_name,
	    u.user_comment
	FROM  ssn_users AS u
	INNER JOIN ssn_accounts AS a ON (u.user_acc = a.acc_id)
	WHERE u.user_is_active = '1' AND u.user_login = '%s' AND u.user_passwd = '%s'", $user_login, $user_password);
	
	$result_1 = self::sql_exec ( self::get_db(), null, $sql);
	$result_auth = array();
	
	foreach ($result_1 as $row) {
		array_push($result_auth, array (
						"acc_id"=>$row['acc_id'],
					 	"user_id"=>$row['user_id'],
					 	"user_login"=>$row['user_login'],
					 	"user_name"=>$row['user_name'],
					 	"user_comment"=>$row['user_comment']
				));
	}
//print_r($result_auth[0]);
	return $result_auth[0];
}

} // class

