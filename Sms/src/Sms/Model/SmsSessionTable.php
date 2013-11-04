<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;

class SmsSessionTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


   public function getInvalidCertMessage(){
   	
		$rowset = $this->tableGateway->select(array('slug' => 'invalid_certificate_message'));
		$row = $rowset->current();
		//print_r($row);
		if(!$row){
			$row = array('value' => 'Output message is not configured');
			
			$row = (object) $row;
			//$this->action_id = 7;
			
		}
		return $row;
		
	}
   
    public function getValidCertMessage(){
   	
		$rowset = $this->tableGateway->select(array('slug' => 'valid_certificate_message'));
		$row = $rowset->current();
		//print_r($row);
		if(!$row){
			$row = array('value' => 'Output message is not configured');
			
			$row = (object) $row;
			//$this->action_id = 7;
			
		}
		return $row;
		
	}

   
}