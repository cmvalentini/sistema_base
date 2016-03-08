<?php

if (defined('DATABASE_CORE_CLASS_DEFINITION'))
	return;
define('DATABASE_CORE_CLASS_DEFINITION','1');

define('DB_CLASS_LOG_CONNECTION_ERRORS_TO_HITS','1');
define('DB_CLASS_TIME_BETWEEN_CONNECT_FAILS_IN_SEC','1');
define('DB_CLASS_MAX_ATTEMPTS_CONNECT_FAILS','20');


/* The MySQL error number when a 'wait_timeout' exceeds.*/
/* Two different values can occur. */
if(!defined('MYSQL_WAIT_TIMEOUT_ERROR_NO1'))
{
	define('MYSQL_WAIT_TIMEOUT_ERROR_NO1', 2013);
}
if(!defined('MYSQL_WAIT_TIMEOUT_ERROR_NO2'))
{
	define('MYSQL_WAIT_TIMEOUT_ERROR_NO2', 2006);
}

//Values to check the acceptable amount of Database instantiation
if(!isset($GLOBALS['database_instance_amount']))
{
	$GLOBALS['database_instance_amount'] = 0;
}
if(!defined('MAX_DATABASE_INSTANCE_AMOUNT'))
{
	define('MAX_DATABASE_INSTANCE_AMOUNT', 500);
}

if(!isset($GLOBALS['database_connection_amount']))
{
	$GLOBALS['database_connection_amount'] = 0;
}
if(!defined('MAX_DATABASE_CONNECTION_AMOUNT'))
{
	define('MAX_DATABASE_CONNECTION_AMOUNT', 500);
}

if(!isset($GLOBALS['database_close_amount']))
{
	$GLOBALS['database_close_amount'] = 0;
}
if(!defined('MAX_DATABASE_CLOSE_AMOUNT'))
{
	define('MAX_DATABASE_CLOSE_AMOUNT', 500);
}
if(!defined('LOG_STATSALES_USAGE_XXX'))
{
	define('LOG_STATSALES_USAGE_XXX', 1);
}

if(!defined('LOG_STAT_USER_RO_USAGE_XXX'))
{
	define('LOG_STAT_USER_RO_USAGE_XXX', 0);
}

if(!defined('LOG_SMS_USAGE_XXX'))
{
	define('LOG_SMS_USAGE_XXX', 0);
}

/*
*@author Ivan Mera
*
*/
Class Database
{
	//atributes
	// @access private
	var $max_connection_attempt = 2;
	var $db_link = false;
	var $db_result = null;
	var $Error = false;
	var $Error_msg = null;
	var $lock_database = false;
	var $magic_quotes_gpc = false;
	var $debug_mode = false;
	var $debug_ip = array('127.0.0.1:8888');
	var $queries = array();
	var $_qa_email = null;
	var $db_server_bkp = array('db-slave1' => 'db-slave2',
								'db-slave2' => 'db-slave1',
								'db-slave-read01' => 'db-slave-read02',
								'db-slave-read02' => 'db-slave-read01',
								);
	var $db_server;
	var $db_username;
	var $db_password;
	var $db_database;
	var $db_persistent;
	//number of automatic reconnect allowed
	var $_auto_reconnect = 10;
	var $_send_email = 'ivan_mera13@hotmail.com';
	
	//asociations
	//operations
	/*
	* Query Constructor where we automatically called connect for a default connection usage
    *   It also register a destructor wich will freeresults if their are not freed and will close the database connection automatically
    *   @access public
    *   @param void
    *   @return void
	*/
	
	function Database( $autoconnect = true)
	{
		if($autoconnect == true)
		{
			$this->connect();
		}
		$this->magic_quotes_gpc = get_magic_quotes_gpc();
	}
	
	/**
	 *	Establish a connection to the database
	 *
	 *	@access public
	 *	@param string $server Host of the server to connect to
	 *	@param string $username Username to use for the connection
	 *	@param string $password Password to use for the connection
	 *	@param string $database Database to use by default
	 *	@param bool $new_link Whether we want to force a new link or not see mysql_connect documentation
	 *	@return void
	 */
	 function connect ( $server = DB_MS_SERVER, $username = DB_MS_SERVER_USERNAME, $password = DB_MS_SERVER_PASSWORD, $database = DB_MS_DATABASE, $persistent = false, $new_link = false )
	 {
		global $db_class_errono;
		global $db_class_error;
		global $db_class_link_fails_stats;
		
		$this->max_connetion_attemp = DB_CLASS_MAX_ATTEMPTS_CONNECT_FAILS;
		// save info to be able to reconnect
		$this->db_server = $server;
		$this->db_username = $username;
		$this->db_password = $password;
		$this->db_database = $database;
		$this->db_persistent = $persistent;
		
		// We make sure to clean the db_result before changing the connection
		if($this->db_result != null)
		{
			$this->freeResult();
		}
		
		$this->db_link = @mysql_connect($this->db_server,$this->db_username,$this->db_password,$new_link);
		if(!is_resource($this->db_link))
		{
			$this->Error = '[Connect Error] - No conneted to Database';
			return $this->Error;
		}else{
			@mysql_select_db($this->db_database, $this->db_link) or die(mysql_error());
		}
		
	 }
	 
	 /**
    *    Close a connection to the database
    *
    *    @access public
	*    @param void
	*    @return void
    */
	function close()
	{
		if ($this->isRessource($this->db_link))
		{
			$result = @mysql_close($this->db_link);
			$this->db_link = false;
		}
	}
	 
	 /**
    *    Allows to execute a query on the current connection
    *    The result set is keep inside the object just inside fetch* to get then row by row
    *
    *    @access public
    *    @param string $query Query to execute on the database
	*    @return void
    */
	
	function query($query)
	{
		if(!$this->isRessource($this->db_link))
		{
			// try connect
			if($this->_auto_reconnect>0)
			{
				$this->resetError();
				$this->connect($this->db_server, $this->db_username, $this->db_password, $this->db_database, $this->db_persistent, true);
				$this->_auto_reconnect--;
			}
			if(!$this->isRessource($this->db_link))
			{
				return FALSE;
			}
		}
		
		/*
		* @global This is use to keep a count of the total query in a script
		*/
		if(!isset($GLOBALS['query_count']))
		{
			$GLOBALS['query_count'] = 0;
		}
		$GLOBALS['query_count']++;
		if($this->db_result != null)
		{
			$this->freeResult();
		}
		$query = rtrim($query, "; \t\n\r\0\x0B");
		
		//we want to escape the query
		$this->db_result = @mysql_query($query, $this->db_link);
		
		if(!$this->db_result)
		{
			//check the MySql error
			$errorNo = mysql_errno($this->db_link);
			if($errorNo == MYSQL_WAIT_TIMEOUT_ERROR_NO1 || $errorNo == MYSQL_WAIT_TIMEOUT_ERROR_NO2)
			{
				//Try to reconnect
				$this->db_link = 0;
				$this->resetError();
				$this->connect($this->db_server, $this->db_username, $this->db_password, $this->db_database, $this->db_persistent, true);
				
				// Run the query again
				$this->db_result = @mysql_query($query, $this->db_link);
				if(!$this->db_result)
				{
					//set error flag
					$this->setError();
					//set result
					$this->db_result = null;
				}
			}else{
				// we added an error
				echo $query.'    '.mysql_error($this->db_link);
				$this->setError();
				$this->db_result = null;
			}
		}
		
		if($this->debug_mode == TRUE && (in_array($_SERVER['REMOTE_ADDR'],$this->debug_ip)))
		{
			$trace = debug_backtrace();
			if(!isset($trace[1]))
			{
				$trace[1]['line'] = $trace[0]['line'];
				$trace[1]['class'] = $trace[0]['file'];
			}
			$trace[1]['line'] = isset($trace[1]['line']) ? $trace[1]['line'] : NULL;
			$this->queries[$trace[1]['class']][] = array('line'=>$trace[1]['line'], 'query'=>$query);	
		}
		//logs for stats, purchases, sms....
	}
	
	 /**
    *    This make sure that the values in the query are escape for the server it is passed to
    *
    *    @access public
    *    @param string $string Value to be escaped
	*    @return mixed The data received once it has been escaped.
    */
	function escapeString($string)
	{
		if($this->isRessource($this->db_link))
		{
			return mysql_real_escape_string($string,$this->db_link);
		}
	}
	
	/**
    *   This make sure that the values in the query are escape for the server it is passed to
	*	This is a special version to be used for LIKE, GRANT and REVOKE statement as _ and % are special character there
    *
    *   @access public
    *   @param string $string Value to be escaped
	*   @return mixed The data received once it has been escaped.
    */
	function escapeStringLike($string)
	{
		if($this->isRessource($this->db_link))
		{
			return addcslashes(mysql_real_escape_string($string,$this->db_link), '%_');
		}
	}
	
	/**
    *    Returns the number of rows in the current result_set
    *    Warn: This is based on the server implementation and may result in bad performance
    *    depending if the server use buffer/unbuffered queries, etc.
    *    Also valid only on select command
    *
    *    @access public
	*	 @param void
	*    @return int The number of rows returned by the database
    */
	function numRows()
	{
		if($this->isResource($this->db_result))
		{
			return @mysql_num_rows($this->db_result);
		}
	}
	
	/**
    *    Returns the number of affected_rows in the last query
    *
    *    @access public
	*	 @param void
	*    @return int The number of altered rows
    */
	function affectedRows()
	{
		if($this->db_result != null)
		{
			return @mysql_affected_rows($this->db_link);
		}
	}
	
	/**
    *    This function allows a data_seek on the result_set
    *
    *    @access public
    *    @param int $row_number The row_number the result_set should be seek to
    */
	function dataSeek($row_number)
	{
		if($this->db_result != null)
		{
			return @mysql_data_seek($this->db_result,$row_number);
		}
	}
	
	/**
    *    Free the result if it's actually a real resource from mysql
    *
    *    @access public
	*    @param void
	*    @return void
    */
	function freeResult()
	{
		if($this->isRessource($this->db_result))
		{
			@mysql_free_result($this->db_result);
			$this->db_result = null;
		}
	}
	
	/**
    *    fetch_array
    *
    *    @access public
	*    @param void
	*    @return array The row associuated to the current position of the cursor in the result set.
    */
	function fetchArray()
	{
		if($this->db_result != null)
		{
			return @mysql_fetch_array($this->db_result);
		}
	}
	
	/**
    *    fetch_row
    *
    *    @access public
    */
	function fetchRow()
	{
		if($this->db_result != null)
		{
			return @mysql_fetch_row($this->db_result);
		}
	}
	
	/**
    *    fetch_assoc
    *
    *    @access public
    */
	function fetchAssoc()
	{
		if($this->db_result != null)
		{
			return @mysql_fetch_assoc($this->db_result);
		}
	}
	
	/**
	 * Function to check if a table exists or not
	 *
	 * @access	public
	 * @param	string	The table name to check
	 * @param	string	The database name to check from if the table exists
	 *
	 * @return	bool	True if table exists, false otherwise
	 */
	function tableExists($tableName, $databaseName = '')
	{
		//check params
		$clean = array();
		if(is_string($tableName) && strlen($tableName) > 0)
		{
			$clean['tableName'] = $tableName;
		}
		if(is_string($databaseName) && strlen($databaseName))
		{
			$clean['databaseName'] = $databaseName;
		}
		//check mandatory param
		if(isset($clean['tableName']))
		{
			//check optional param
			if(isset($clean['databaseName']))
			{
				$sql = 'SHOW TABLES FROM `' .$this->escapeString($clean['databaseName']) .'` LIKE "'. $this->escapeString($clean['tableName']) . '"';
			}else{
				$sql = 'SHOW TABLES LIKES "'. $clean['tableName'] .'"';
			}
			//Execute Query
			$this->query($sql);
			if($this->numRows() > 0)
			{
				//if exists
				return true;
			}
		}
		// return any value
		return false;
	}
	
	/**
	*    selectDb
	*
	*    @access public
	*    @param string $db_name Name of the database which we have to select
	*/
	function selectDb( $db_name )
	{
		if($this->isRessource($this->db_link))
		{
			if($this->lock_database == true)
			{
				#$my_error = &createError();
				#$my_error->add_ctrl_mail($this->_qa_mail);
				#$my_error->addError(ERROR_WARN,'The database is locked you can\'t change the database',__FILE__,__FUNCTION__,__LINE__);
				$this->Error = true;
			}else{
				$result = @mysql_select_db($db_name, $this->db_link);
				if(!$result)
				{
					//add error
					#$my_error = &createError();
					#$my_error->add_ctrl_mail($this->_qa_email);
					#$my_error->addError(ERROR_WARN,'Impossible to change database',__FILE__,__FUNCTION__,__LINE__);
					#$my_error->addError(ERROR_DEBUG,'Error produced ' .mysql_errno($this->db_link). ' '.mysql_error($this->db_link),__FILE__,__FUNCTION__,__LINE__);
	                $this->setError();
					return null;
				}else{
					//save db change
					$this->db_database = $db_name;
				}
			}
		}
	}
	// Function to control the error flag of the database
	/**
	*    failed - Return TRUE or FALSE to indicate a failure event
	*
	*    @access public
	*/
	function failed ()
	{
		return $this->Error;
	}
	
	/**
	 * Set the Error attrivute to value (default true)
	 * You can customize this function with debugging information in your local machine
	 * @param $value Value to set the error too
	 * @access private
	 * @return void
	 */	
	function setError($value = true)
	{
		$this->Error = $value;
		$this->Error_msg = @mysql_error($this->db_link);
	}
	
	/**
	*    resetError - Reset the failed flag to false
	*
	*    @access public
	*/
	function resetError()
	{
		$this->Error = false;
	}
	
	/**
	*    setLockDatabase - Set the lock value to $value
	*
	*    @access public
	*/
	function setLockDatabase($value)
	{
		$this->lock_database = $value;
	}
	
	/**
	*    getLockDatabase - Reset the failed flag to false
	*
	*    @access public
	*/
	function getLockDatabase()
	{
		return $this->lock_database;
	}
	
	/**
	*    getQueryCount - Return the number of query done since the loading
	*
	*    @access public
	*/
	function getQueryCount()
	{
		return $GLOBALS['query_count'];
	}
	
	/**
	*    Activate the query debug mode.
    *
	*    @access public
    *    @param bool $status TRUE/FALSE True if we want to debug queries
    *    @return void
	*/
	function setDebugMode($status)
	{
		$this->debug_mode = (bool) $status;
	}
	
	/**
	*    Return an array with all the queries executed since the debug mode was set to TRUE;
    *
	*    @access public
    *    @param void
    *    @return string Queries to be debuged.
	*/
	function debugQueries()
	{
		if ($this->debug_mode == TRUE && (in_array($_SERVER['REMOTE_ADDR'],$this->debug_ip)))
		{
			ob_start();
			var_dump($this->queries);
			$queries = ob_get_contents();
			ob_end_clean();
			return $queries;
		}
	}
	
	/**
	*    Check if the ressource received is valid.
	*	 If it is not valid Trhow an error
    *
	*    @access private
    *    @param ressource $resssouce A ressource
    *    @return bool TRUE If the data received is a ressource else FALSE
	*/
	function isRessource($ressource)
	{
		if(!is_resource($ressource))
		{
			return FALSE;
		}else{
			return TRUE;
		}
	}
	
	/**
	*    Check if their are un freed results and free them if possible
    *    and close the connection to mysql
	*
	*    @access public
    *    @param void
    *    @return void
	*/
	function __destruct()
	{
		if(!is_null($this->db_result))
		{
			$this->freeResult();
		}
	}
	
	/**
	*	add_ctrl_email: Allows email to the receiving error without duplicate
	*
	*	@access public
	*	@param string $qa_mail Email to add
	*/
	function add_ctrl_email($qa_mail)
	{
		if(!empty($qa_mail) && is_string($qa_mail))
		{
			$this->_qa_email = $qa_mail;
		}else{
			$this->_qa_email = _send_email;
		}
	}
	
	/**
	* Return all tables of the DB where are onnected
	* @access public
	*/
	function getListOfTables()
	{
		$tables_return = array();
		$this->query("SHOW TABLES");
		while($row = $this->fetchRow())
		{
			$tables_return[] = $row[0];
		}
		$this->freeResult();
		return $tables_return;
	}
	
	/**
	*	Add `s identifiers
	*   @access public
	*/
	function quoteIdentifier($str)
	{
		return '`'. $str .'`';
	}
	
	/**
	*	Do a query and return full result in array
	*	@access public
	*/
	function getAll($query){
		$data_return = array();
		$this->query($query);
		while($row = $this->fetchAssoc())
		{
			$data_return[] = $row;
		}
		$this->freeResult();
		return $data_return;
	}
	
	/**
	*	Do a query and return one result
	*	@access public
	*/
	function getOne($query)
	{
		$data_return = FALSE;
		$this->query($query);
		if($row = $this->fetchRow())
		{
			$data_return = $row[0];
		}
		$this->freeResult();
		return $data_return;
	}
	
	/**
	*	Same as tep_db_get_assoc(), only values are stored in an array
	*	for each key, allowing you to store several values
	*	for the same key.
	*	
	*	Optionally you can specify if values for each key are unique.
	*
	*	@param string Select SQL query
	*	@return array rows selected or empty array if no results found or error
	*
	*	@access public
	*	@see tep_db_get_assoc
	*/
	function getAssocMultiple($query, $unique=true)
	{
		$result = array();
		$this->query($query);
		while($row = $this->fetchAssoc())
		{
			$key = array_shift($row);
			if(empty($result[$key]))
			{
				$result[$key] = array();
			}
			if(count($row)>1)
			{
				$value = $row;
			}else{
				$value=current($row);
			}
			if(!$unique || !in_array($value, $result[$key]))
			{
				$result[$key][] = $value;
			}
		}
		$this->freeResult();
		return $result;
	}
}
//End script
?>