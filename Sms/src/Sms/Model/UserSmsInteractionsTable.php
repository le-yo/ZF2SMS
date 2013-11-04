<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

class UserSmsInteractionsTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }



    public function getCompletedExamInteraction($user_id,$testID){
        
		//return $testID;
		//exit();
		
       $rowset = $this->tableGateway->select(array(
        'user_id' => $user_id,
		'quiz_id' => $testID,
		'activity' => 10,
		));
		//$count = count($rowset);
	$resultSet = new ResultSet;
    $resultSet->initialize($rowset); 
  	if(!$resultSet){
			$row = array('count' => 0,'score'=> null);
			
			$row = (object) $row;
			//$this->action_id = 7;
			return $row;
			
		}else{
	
    $count = count($resultSet);
    $score = -1;
	$output = "";
    foreach ($resultSet as $row) {
    	if($row->score>$score){
        $score = $row->score;
			$output = $row;
		}
        //$i++;
    }
	
	//print_r($row);
	//exit();
	$return = array($count,$output);
	return $return;
		
        
    }
	}
   public function createActivity($data){
   //	print_r($data);
	//exit();  
     //echo 'hapa';
		//exit();
         $result= $this->tableGateway->insert($data);
		 return $result;
		 //return 1;
    }
    
    public function updateActivity($data,$user_id,$activity){
        $result = $this->tableGateway->update($data, array(
        'user_id'=>$user_id,
		'activity'=>$activity
		));
        return $result;
    }
	
	public function getScore($userID,$testID){
   	$rowset = $this->tableGateway->select(array(
   	'quiz_id' => $testID,
   	'user_id' => $userID,
   	'activity' => 10
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