<?php
namespace Sms\Model;

use Zend\Db\Sql\Select;
use Zend\Db\TableGateway\TableGateway;
use Zend\Db\ResultSet\ResultSet;

class QuestionResponsesTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


   public function createResponse($data){       
         $result= $this->tableGateway->insert($data);
     return $result;
    }
    
   // public function getUserResponses($user_id,$testID){
//    	
	// //testing
	// $rowset = $this->tableGateway->select(function (Select $select) {
     // $select->where( array(
   		// //'quiz_id' => $testID,
   		 // 'quiz_id' => $testID,
   		// 'user_id' => $user_id
//     		
   		// ));
     // $select->order('id DESC')->limit(1);
// });
  // $row = $rowset->current();
// 	
 // return $row; 
   // }	
// }

public function getresponse($question_ID,$user_id){
$rowset = $this->tableGateway->select(array(
   		 'question_id' => $question_ID,
   		 'user_id' => $user_id
   		));
// 
// 
  $resultSet = new ResultSet;
    $resultSet->initialize($rowset); 
    //$i = 'A';
    $choices_id = 0;
	$choices = "";
    foreach ($resultSet as $row) {
    	if($row->id>$choices_id){
        $choices_id = $row->id;
			$choices = $row;
		}
        //$i++;
    }
	$choicesdata = $choices;
		//return $user_id;
 
 //$row = $rowset->current();
	
 return $choicesdata; 
}

}