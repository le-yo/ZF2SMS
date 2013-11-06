<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

class ProgressTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }
     //function to get next message
		  function get_user_application_progress(Progress $progress){
		   //$query = mysql_query("SELECT progress FROM sms_application_progress WHERE phone_num='$from_number'");
		  	$from_number= $from_number;
		  	$rowset=$this->tableGateway->select(array('phone_num'=>$from_number));
		  	$row=$rowset->current();



		  	if(!$row)
		  	{
		  		throw new \Exception('Could not find row $from_number');
		  	}

		  	$rowCount=count($rowset);

		  //	return $row;
		  	$progress = $row['progress']; 
		   	return $progress;

		   		if($rowCount > 0)
				{
					$progress = 1;
				}else{
				$progress = 0;

			//$qu = mysql_query("INSERT INTO sms_application_progress (phone_num,progress) VALUES ('$from_number','1')");
			//insert progres,num,values
				// $data=array(
				// 	'phone_num'=>$progress->phone_num,
				// 	'progress'=>$progress->progress
				// 	);

				$qu=$this->tableGateway->insert->values(array(

					'phone_num'=>$from_number,
					'progress'=>1

					));

			if($qu){

			welcome_request_first_name($from_number, $message);

  				}
				

			}

		   //get progress function
		   //$row = mysql_fetch_array($query);
		 // $this->tableGateway->insert($progress);
		}

	  	function update_application_progress($progress,$from_number){
				$progress=$progress+1;
			 	//$qu = mysql_query("UPDATE sms_application_progress SET progress = $progress WHERE phone_num=$from_number");

				$data=array(
					'progress' => $progress
					);
					
				$this->tableGateway-update($data, array('phone_number'=>$from_number));

			}

}