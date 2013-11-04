<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;

class SmsSwitch
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


   public function getSmsSwitchAction($message){
		
		//$id = (int) $id;
		/*$rowset = $this->tableGateway->select(array('prefix' => 1));
		$row = $rowset->current();
		if(!$row){
			throw new \Exception("No SMS Gateway has been configured");	
		}
		return $row;
		*/
		  $submessage = substr($message, 0, 3)."%";
			   //echo $submessage;
			   //compare with the prefixes on the database
			    $query = mysql_query("SELECT id FROM sms_switch WHERE prefix LIKE '$submessage'");
				
				if(mysql_num_rows($query)> 0){
				
				$row = mysql_fetch_array($query);
				//print_r($row);
				//check if row_id
				
			   return $row['id']; 
			    //$switch_message = "Welcome to the ".$category." subsystem";
				
				}
				else{
				$query = mysql_query("SELECT id,message FROM sms_switch WHERE prefix='$message'");	
					if(mysql_num_rows($query)> 0){				
				    $row = mysql_fetch_array($query);
					return $row['id'];
					}else{ 	
					return 7;
					}
				//$switch_message = "Welcome to the testing module. You don't have any running tests";	
				//$user_exists = 0;
				}
		
		
	}

   
}