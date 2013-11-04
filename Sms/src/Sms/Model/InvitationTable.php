<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

class InvitationTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


   public function getNextQuestion($testID,$progress){
   	$rowset = $this->tableGateway->select(array(
   		'quiz_id' => $testID,
   		'id' => $progress
   		));
		$row = $rowset->current();
		//print_r($row);
		if(!$row){

			$row = array('question_text' => 'A strange error just occured');
			
			$row = (object) $row;
			//$this->action_id = 7;
			
		}
		return $row;
   }

public function getFirstQuestionID($testID) { 
  //$testID
  //break;
   $rowset = $this->tableGateway->select(array(
      'quiz_id' => $testID,
      //'id' => $progress
      ));
    $row = $rowset->current();
            return $row;
}


public function getQuestion($questionID) { 
  //$testID
  //break;
   $rowset = $this->tableGateway->select(array(
      'id' => $questionID,
      //'id' => $progress
      ));
    $row = $rowset->current();

            return $row;
}

public function getInvitedUsers($courseID){

$InvitedUsers = '';
    $rowset = $this->tableGateway->select(array(
      //'quiz_id' => $testID,
      'course_id' => $courseID
      ));

  $resultSet = new ResultSet;
    $resultSet->initialize($rowset);
    //$i = 'A';
    //$choices = "";
    if(empty($resultSet)){
		$InvitedUsers = 0;
}else{
    foreach ($resultSet as $row) {
        $InvitedUsers[] = $row->phone_number;
        //$i++;
    }
	
}
    return $InvitedUsers;
   }

public function getPendingInvites(){


    $rowset = $this->tableGateway->select(array(
      //'quiz_id' => $testID,
      'status' => 0
      ));

  $resultSet = new ResultSet;
    $resultSet->initialize($rowset);
    //$i = 'A';
    //$choices = "";
    if(empty($resultSet)){
		$InvitedUsers = 0;
}else{
	$PendingInvitedUsers = array();
	
    foreach ($resultSet as $row) {
    	array_push($PendingInvitedUsers,array($row->phone_number,$row->message,$row->course_id,$row->course_name));
        //$InvitedUsers[] = $row->phone_number;
        //$i++;
    }
	
}
$Invitations = array('invitation' => $PendingInvitedUsers );
    return $Invitations;
   }

public function updateStatus($phone_number){
	$data = array(
	'status' => 1
	);
        $result = $this->tableGateway->update($data, array('phone_number'=>$phone_number));
        return $result;
    }


 }