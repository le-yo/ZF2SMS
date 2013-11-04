<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;
// use Zend\Db\Adapter\Adapter;
// use Zend\Db\ResultSet\ResultSet;
// use Zend\Db\Sql\Select;
// use Zend\Db\Sql\limit;
// use Zend\Db\Adapter\Driver\DriverInterface;
// use Zend\Db\Sql\Expression;


class SmsgatewayTable{
	//call tablegateway
	protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }




	//Handles selection of a particular course
	public function getSmsgateway(){
		
		//$id = (int) $id;
		$rowset = $this->tableGateway->select(array('status' => 1));
		$row = $rowset->current();
		if(!$row){
			throw new \Exception("No SMS Gateway has been configured");	
		}
		return $row;
	}



}
?>