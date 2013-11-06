<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;

class UserCertificatesTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


   public function getCertUserID($from_number,$message){
   	
		$rowset = $this->tableGateway->select(array(
		'certificate_code' => $message,
		'status' => 1
		
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
  public function user_certificate($user_id){
         //print_r($user_id);
		 //exit();
		 $rowset = $this->tableGateway->select(array('user_id' =>$user_id,'status' =>0));
		$row = $rowset->current();
        //$resultSet=$this->tableGateway->select(array('user_id' => $user_id));
		 //$row=$resultSet; 
		 if(!$row){
			$row = array('certificate_code' => 0);
			
			$row = (object) $row;
			//$this->action_id = 7;
			
		}
		 //print_r($row);
		 //exit();
		return $row;
		 
		 
		// return $row;
        
    }
     
   public function createCertificate($userCertdata){
   	$result= $this->tableGateway->insert($userCertdata);
		 return $result;
   	
   }
   public function updatestatus($id){
  		$data = array(
		'status'=> 1,
		);
        $result = $this->tableGateway->update($data, array('id'=>$id));
        return $result;
   }
}