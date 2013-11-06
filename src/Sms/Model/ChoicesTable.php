<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

class ChoicesTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


   public function getChoices($QuestionID){


   	$rowset = $this->tableGateway->select(array(
   		//'quiz_id' => $testID,
   		'question_id' => $QuestionID
   		));

  $resultSet = new ResultSet;
    $resultSet->initialize($rowset);
    $i = 'A';
    $choices = "";
    foreach ($resultSet as $row) {
        $choices = $choices.$i.":".$row->answer_text. PHP_EOL;
		// if($row->is_correct_answer==1){
			// $correctAnswer = $i;
		// }
        $i++;
    }

		return $choices;
   }
   
   
      public function getChoices4DailyQuestion($QuestionID){


   	$rowset = $this->tableGateway->select(array(
   		//'quiz_id' => $testID,
   		'question_id' => $QuestionID
   		));

  $resultSet = new ResultSet;
    $resultSet->initialize($rowset);
    $i = 'A';
    $choices = "";
	$correctAnswer = '';
    foreach ($resultSet as $row) {
        $choices = $choices.$i.":".$row->answer_text. PHP_EOL;
		if($row->is_correct_answer==1){
			$correctAnswer = $i;
		}
        $i++;
    }

		return $choices.PHP_EOL."Correct answer: ".$correctAnswer;
   }
   
   //choices validation
   public function getChoicesData($QuestionID){


   	$rowset = $this->tableGateway->select(array(
   		//'quiz_id' => $testID,
   		'question_id' => $QuestionID
   		));

  $resultSet = new ResultSet;
    $resultSet->initialize($rowset);
    $i = 'A';
    $choices = "";
    foreach ($resultSet as $row) {
        $choices[$i] = array($i => array( $row->id,$row->answer_text ));
        $i++;
    }
	$choicesdata = $choices;
		return $choicesdata;
   }
   
     public function getRightChoice($value){

// $rowset=$this->tableGateway->select(array('phone_num'=>$from_number));
		  	// $row=$rowset->current();


   	$rowset = $this->tableGateway->select(array(
   		'is_correct_answer' => '1',
   		'question_id' => $value
   		));
$row = $rowset->current();
  
	if($row){
		return $row;
	}
	else{
		$row = array('id' => 0 );
		$row = (object) $row;
		return $row;
	}
	 }

   
}