<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;

class SmsSwitchTable
{
    protected $tableGateway;


    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


   public function getSmsSwitchAction($message){
	$action = '';
		//$id = (int) $id;
   	for ($i=1; $i < 7; $i++) { 
   		$prefix = $this->getPrefix($i);
   		$prefixlength = strlen($prefix->prefix);
   		if(strlen($message)<$prefixlength){
   			break;
   		}else{
   		$submessage = substr($message, 0, $prefixlength);

//stripos($submessage, $prefix->prefix)
   		if(stripos($submessage, $prefix->prefix)!== false){
   			$action = $prefix;
   			return $action;
   			break;
   		}else{

   			
   		}
   		//return $prefixlength;
   		//exit;
        }
   	}

   	if(!$action){
   		$rowset = $this->tableGateway->select(array('prefix' => $message));
        $action = $rowset->current();
        if(!$action){
			$row = array('action_id' => 7,'category' => 'session');
			$action= (object) $row;
			//return $row;
		}
		return $action;
			}

		// //$submessage = substr($message, 0, 4);
		// //echo $submessage;
		// //$rowset = $this->tableGateway->select->where('prefix LIKE?',$submessage.'%');
		// //$rowset = $this->tableGateway->select(array('prefix LIKE ?' => $submessage.'%'));
		// //$row = $rowset->current();
		// //print_r($row);
		// if(!$row){
			
		// 	$rowset = $this->tableGateway->select(array('prefix' => $message));
		// 	$row = $rowset->current();
		// 	if(!$row){
		// 	$row = array('action_id' => 7,'category' => 'session');
		// 	$row = (object) $row;
		// 	}	
		// 	//$this->action_id = 7;
			
		// }
		// return $row;
		
	}

	public function getPrefix($id){
   	
		$rowset = $this->tableGateway->select(array('id' => $id));
		$row = $rowset->current();
		//print_r($row);
		if(!$row){
			$row = array('prefix' => 'Not configured');
			
			$row = (object) $row;
			//$this->action_id = 7;
			
		}
		return $row;
		
	}

   
}