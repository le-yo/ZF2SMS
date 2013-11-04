<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;

class RegistrationTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }

    public function registration()
    {
    	 update_sms_session($from_number,0);
			$user_exists = check_if_user_is_already_registered($from_number);
			if($user_exists==1){
		
				
				$progress = get_user_application_progress($from_number);
					
			switch ($progress) {
   			case 1: 
			welcome_request_first_name($from_number, $message, $progress);
        	//welcome_request_first_name(); 
       		break;
			case 2:
    		request_last_name($from_number,$message,$progress);
    		break;
    		case 3:
    		request_location($from_number,$message,$progress);
			break;
			case 4:
    		request_id($from_number,$message,$progress);
       		break;
			case 5:
    		request_pin($from_number,$message,$progress);
       		break;
			case 6:
    		thank_you_message($from_number, $message, $progress);
			break;
			case 7:
			json_encodize("You are already registered", $from_number);	
			
			//echo $from_number;
       		break;
    		default:
       		register($from_number,$message);
      		break;
			}
			
				
			}else{
			//$query = mysql_query("INSERT INTO users (phone_number) VALUES ('$from_number')"); //insert($db,$data,$values)

			
			// $qu = mysql_query("INSERT INTO sms_application_progress (phone_num,progress) VALUES ('$from_number','1')");
			// //insert progres,num,values

			// if($qu){

			// welcome_request_first_name($from_number, $message);

  	// 		}
						
		}

}

function welcome_request_first_name($from_number,$message,$progress=1){
			//update application progress and get next message	
		 $msg = update_application_progress_and_get_next_message($progress, $from_number);
				
			//send back JSON
			//json_encodize($msg, $from_number);
			
			} 


}




