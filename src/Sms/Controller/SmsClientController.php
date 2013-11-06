<?php

namespace Sms\Controller;
 
use Zend\Mvc\Controller\AbstractActionController;
use Zend\Http\Client as HttpClient;
 
class SmsClientController extends AbstractActionController
{
	protected $SmsgatewayTable;
    public function indexAction()
    {
    	//echo 'hapa';
		
    	$sms_gateway =$this->getSmsgatewayTable()->getSmsgateway();
       // print_r($sms_gateway);
	   // exit();
//lets get the sms_gateway_id and use it to 
	 	    $sms_gateway_id = $sms_gateway->id;
	  
//now that we have the gateway id, lets use the gateway to get the incoming message details from our gateway

	  	    $received_msg =$this->get_message_details($sms_gateway_id); 
		  
		  // print_r($received_msg);
	   // exit();
		  
        $client = new HttpClient();
        $client->setAdapter('Zend\Http\Client\Adapter\Curl');
         
        $method = $this->params()->fromQuery('method', 'get');
		$client->setUri('http://beta.akengo.com/Sms/SmsRestful');
		// print_r($client);
	   // exit();
		
		 //$client->setUri('http://localhost:80'.$this->getRequest()->getBaseUrl().'/Sms?from=254&message=Akengo');
		 
		 if(!empty($_REQUEST['task'])){
		 // $client->setMethod('POST');
                // $client->setParameterPOST(array('from'=>$received_msg['from_number'],'message'=>'invitation','sms_gateway_id'=>$sms_gateway_id));
// 		 	
$received_msg['from'] = 'cron';

$client->setMethod('POST');
$client->setParameterPOST(array('from'=>$received_msg['from'],'message'=>'INVITATION','sms_gateway_id'=>$sms_gateway_id));
 	

//echo 'tuko kwa task';
//exit();
			
			
		}
		 if($_REQUEST['from'] == '1111'){  
		 	
			//echo 'cronner';
			// exit();
			$client->setMethod('POST');
                $client->setParameterPOST(array('from'=>1111,'message'=>$received_msg['message'],'sms_gateway_id'=>$sms_gateway_id));
 	
			
		}
		
		
		else{
			//if it is a payment message
		 if($_REQUEST['from'] == 'MPESA'){
			$client->setMethod('POST');
                $client->setParameterPOST(array('from'=>$received_msg['message'],'message'=>'PAYMENT','sms_gateway_id'=>$sms_gateway_id));
 	
			
		}else{
			if(!empty($_REQUEST['task'])){
					$received_msg['from'] = 'cron';

$client->setMethod('POST');
$client->setParameterPOST(array('from'=>$received_msg['from'],'message'=>'INVITATION','sms_gateway_id'=>$sms_gateway_id));
 	
					
					
					
				//echo "task";
				//exit();
			//$client->setMethod('POST');
                //$client->setParameterPOST(array('from'=>$received_msg['message'],'message'=>'PAYMENT','sms_gateway_id'=>$sms_gateway_id));
 			
		}else{
			if(strtolower($_REQUEST['message'])=='demo'){
				//echo "hapa";
				//exit();
			$client->setMethod('POST');
                $client->setParameterPOST(array('from'=>$received_msg['from_number'],'message'=>'#trial3','sms_gateway_id'=>$sms_gateway_id));
 			
		}else{
			
			//echo "kwa root";
			//exit();
		 $client->setMethod('POST');
                $client->setParameterPOST(array('from'=>$received_msg['from_number'],'message'=>$received_msg['message'],'sms_gateway_id'=>$sms_gateway_id));
		//echo 'hapa';
		}
		}
		}
		 }
		$response = $client->send();
		
        if (!$response->isSuccess()) {
            // report failure
            $message = $response->getStatusCode() . ': ' . $response->getReasonPhrase();
             
            $response = $this->getResponse();
            $response->setContent($message);
            return $response;
		}
        //print_r($response);
		//exit();
        $body = $response->getBody();
         
        $response = $this->getResponse();
		   
        $response->setContent($body);
         
        return $response;
		 
		 
		
    }
public function getSmsgatewayTable()
    {
        if (!$this->SmsgatewayTable) {
            $sm = $this->getServiceLocator();
            $this->SmsgatewayTable = $sm->get('Sms\Model\SmsgatewayTable');
        }
        return $this->SmsgatewayTable;
    }
	
	public function get_message_details($sms_gateway_id){
		//If we are using SMSSync id=1 and we do the following
	if($sms_gateway_id==1){
		if(!empty($_REQUEST['from'])){
		$msg_details['from_number'] = trim($_REQUEST['from']);
		}
		if(!empty($_REQUEST['message'])){
			$msg_details['message'] = trim($_REQUEST['message']);
		}
		
		if(!empty($_REQUEST['task'])){
			$msg_details['task'] = trim($_REQUEST['task']);
		}
		return $msg_details;
		
	}
	//If we are using Africastalking we do the following
	if($sms_gateway_id==2){
		//we will write this code from Africastalking documentation
		
	}
	/* future sms gateway will be setup here to be used
	 if($sms_gateway_id==X){
		we will write this code from Africastalking documentation
		
	}*/

	else{
		//
	}
		
	}

}