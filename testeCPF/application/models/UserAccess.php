<?php

class Application_Model_UserAccess
{
	private $_dbTable;
	public function __construct()
	{
		$this->_dbTable = new Application_Model_DbTable_User;
	}
	
	public function authenticate($login, $password)
	{
		$select = $this->_dbTable->select()
		->where('login = ?', $login)
		->where('password = ?', $password);
		$stmt = $select->query();
		$result = $stmt->fetchAll();
		if(!empty($result)){
			return true;
		} else {
			return false;
		}
	}
}

