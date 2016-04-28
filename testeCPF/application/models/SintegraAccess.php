<?php

class Application_Model_SintegraAccess
{
	private $_dbTable;
	public function __construct()
	{
		$this->_dbTable = new Application_Model_DbTable_Sintegra;
	}
	
	public function getAllEntries()
	{
		$select = $this->_dbTable->select();
		$stmt = $select->query();
		$result = $stmt->fetchAll();
		
		return $result;
	}
	public function addUnique($data)
	{
		
		$select = $this->_dbTable->select()->where('cnpj = ?', $data['cnpj']);
		$stmt = $select->query();
		$result = $stmt->fetchAll();
		if(empty($result)) {
			$this->_dbTable->insert($data);
		} else {
			if($data['id_usuario'] != $result['id_usuario'] || $data['json'] != $result['json']) {
				$where = $this->_dbTable->getAdapter()->quoteInto('cnpj = ?', $data['cnpj']);
				$this->_dbTable->update($data, $where);
			}
		}
	}
	
	public function delete($id)
	{
		$where = $this->_dbTable->getAdapter()->quoteInto('id = ?', $id);
		$this->_dbTable->delete($where);
	}
}

