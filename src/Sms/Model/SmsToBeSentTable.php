<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

class SmsToBeSentTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


public function createSmsToBeSent($data){
   	//print_r($data);
	//exit();  
     //echo 'hapa';
		//exit();
         $result= $this->tableGateway->insert($data);
		 return $result;
		 //return 1;
    }






public function getPendingSmses(){


    $rowset = $this->tableGateway->select(array(
      //'quiz_id' => $testID,
      'status' => 0
      ));

  $resultSet = new ResultSet;
    $resultSet->initialize($rowset);
    //$i = 'A';
    //$choices = "";
    if(empty($resultSet)){
		$PendingSmses = 0;
}else{
	$PendingSmses = array();
	
    foreach ($resultSet as $row) {
    	array_push($PendingSmses,array($row->message,$row->to,$row->id));
        //$InvitedUsers[] = $row->phone_number;
        //$i++;
    }
	
}
$Smses = array('sms_to_be_sent' => $PendingSmses);
    return $Smses;
   }

public function updatestatus($id){
	$data = array(
	'status' => 1
	);
        $result = $this->tableGateway->update($data, array('id'=>$id));
        return $result;
    }


 }