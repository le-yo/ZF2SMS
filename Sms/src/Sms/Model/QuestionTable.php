<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

const ORDER_ASCENDING = 'ASC'; 
const ORDER_DESENDING = 'DESC';

class QuestionTable
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

public function getQuestionIDs($quizID){

$QuestionIds = '';
    $rowset = $this->tableGateway->select(array(
      //'quiz_id' => $testID,
      'quiz_id' => $quizID
      ));

  $resultSet = new ResultSet;
    $resultSet->initialize($rowset);
    //$i = 'A';
    //$choices = "";
    if(empty($resultSet)){
		$QuestionIds = 0;
}else{
    foreach ($resultSet as $row) {
        $QuestionIds[] = $row->id;
        //$i++;
    }
	
}
    return $QuestionIds;
   }
 }