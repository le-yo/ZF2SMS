<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;

class UserTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


   public function getUserDetails($UserID){
   		//echo $UserID;
		$rowset = $this->tableGateway->select(array('user_id' => $UserID));
		$row = $rowset->current();
		//print_r($row);
		if(!$row){
			$row = array('first_name' => 'A.N','last_name' => 'Other');
			
			$row = (object) $row;
			//$this->action_id = 7;
			
		}
		return $row;
		
	}
    public function checkUserDetails($from_number){
        
        $rowset = $this->tableGateway->select(array('phone_number' => $from_number));
		$row = $rowset->current();
		//print_r($row);
		if(!$row){
			$row = array(
			'from_number' => 0,
			'id' => 0
			);
			
			$row = (object) $row;
			//$this->action_id = 7;
			
		}
		return $row;
        
    }

    public function createUserWithReferral($from_number,$message){

    	$data=array(
                            'phone_number'=>$from_number,
                            'session'=>1,
                            'progress'=>1,
                            'test_to_take'=>$message
                        );
    	$result= $this->tableGateway->insert($data);
		$id = $this->tableGateway->lastInsertValue;
		 return $id;
    }

    public function createUser($from_number,$referred=0){
    	 

         $data=array(
                            'phone_number'=>$from_number,
                            'session'=>1,
                            'progress'=>1
                        );   
     
         $result= $this->tableGateway->insert($data);
		 
		 $id = $this->tableGateway->lastInsertValue;
		 return $id;
    }
    
    public function updateUser($data,$from_number){
        $result = $this->tableGateway->update($data, array('phone_number'=>$from_number));
        return $result;
    }

   
}