<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

class QuizTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


   public function getQuizDetails($id){
   	$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		//print_r($row);
		if(!$row){
			//$LastID = getLastInsertValue();
			$row = array('id' => 0,
			//'largest'=> $LastID
			);
			
			$row = (object) $row;
			//$this->action_id = 7;
			
		}
		return $row;
   }
   public function getQuizdetail($classID){


    $rowset = $this->tableGateway->select(array(
      //'quiz_id' => $testID,
      'class_id' => $classID
      ));

  $resultSet = new ResultSet;
    $resultSet->initialize($rowset);
    //$i = 'A';
    //$choices = "";
    if(empty($resultSet)){
		$testIds = 0;
}else{
    foreach ($resultSet as $row) {
        $testIds[] = $row->id;
        //$i++;
    }
	
}
    return $testIds;
   }
  
  public function updateRewardStatus($data,$id){
        $result = $this->tableGateway->update($data, array('id'=>$id));
        return $result;
    }
   
   public function activate($id){
   	$data = array(
	'published' => 1
	);
   	$result = $this->tableGateway->update($data, array('id'=>$id));
        return $result;
   	
   }
   

   
}