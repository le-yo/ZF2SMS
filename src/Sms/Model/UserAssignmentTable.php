<?php
namespace Sms\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

class UserAssignmentTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


   public function createScore($data){       
         $result= $this->tableGateway->insert($data);
     return $result;
    }
   
   public function getScore($userID,$testID){
   	$rowset = $this->tableGateway->select(array(
   	'assignment_id' => $testID,
   	'user_id' => $userID
	));
		$row = $rowset->current();
		//print_r($row);
		if(!$row){
			$row = array('user_id' => 0);
			
			$row = (object) $row;
			//$this->action_id = 7;
			
		}
		return $row;
	
   }

}