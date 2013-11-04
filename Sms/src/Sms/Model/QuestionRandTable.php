<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

//const ORDER_ASCENDING = 'ASC'; 
//const ORDER_DESENDING = 'DESC';

class QuestionRandTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


   public function createRandomization($data){       
         $result= $this->tableGateway->insert($data);
     return $result;
    }

    public function updateRandomization($QuestionOrder,$testID,$user_id,$status){
    	$data=array(
            //'user_id'=>$user_id,
            'status'=>$status,
            'order'=>$QuestionOrder
        );

        $result = $this->tableGateway->update($data, array(
        	'user_id'=>$user_id,
            'quiz_id'=>$testID
        	));
        return $result;
    }
   
   public function getQuestionOrder($testID,$user_id){
   	$result = $this->tableGateway->select(function (Select $select) use ($testID,$user_id)  {
       $select->where(array(
       	'quiz_id' => $testID,
   		'user_id' => $user_id,
   		'status' => 0
   		)); 
       $select->order(array('id DESC'))->limit(1);
        }); 

   	$resultSet = new ResultSet;
    $resultSet->initialize($result);
    //$order= '';
if(!$result){
			$row = array('order' => 0);			
			$order = json_encode($row);
			//$this->action_id = 7;			
		}
		else{

    foreach ($resultSet as $row) {
        $order = $row->order. PHP_EOL;
        //$i++;
    }
}
		if(empty($order)){
			$order = 0;
			return $order;
		}else{
		return json_decode($order);
		}
   
   }

   
}