<?php

namespace Sms\Controller;

use Zend\Mvc\Controller\AbstractRestfulController;
use DateTime;
use DateTimeZone;
use Sms\Library\AfricasTalking;
//require_once 'Zend/Date.php';
//use Zend_Date;
 
//date_default_timezone_set('Africa/Nairobi');
class SmsRestfulController extends AbstractRestfulController
{
	protected $SmsTable;
    protected $RegistrationTable;
    protected $ProgressTable;
	protected $SmsgatewayTable;
	protected $SmsSwitchTable;
	protected $UserCertificatesTable;
	protected $SmsSettingsTable;
	protected $UserTable;
	protected $CertificatesTable;
	protected $CourseTable;
    protected $QuizTable;
    protected $QuestionTable;
    protected $ChoicesTable;
    protected $QuestionRandTable;
    protected $QuestionResponsesTable;
	protected $UserSmsInteractionsTable;
	protected $UserAssignmentTable;
	protected $InvitationTable;
	protected $ClassTable;
	protected $paymentsTable;
	protected $SmsToBeSentTable;
	
	 public function createAction()
    {
	//lets first check the sms gateway being used
	// echo "hapa";
	// exit;
      	//$sms_gateway =$this->getSmsgatewayTable()->getSmsgateway();
       //echo $sms_gateway;
	   
//lets get the sms_gateway_id and use it to 
	 	$sms_gateway_id = $_REQUEST['sms_gateway_id'];
	  
//now that we have the gateway id, lets use the gateway to get the incoming message details from our gateway
if(!empty($_REQUEST['from'])){
	  $received_msg['from_number'] = $_REQUEST['from'];
}
	  $received_msg['message'] =  $_REQUEST['message'];
	  
     	// print_r($received_msg);
		// exit();
//where do we direct the SMS? We get the action_id from our wonderful switch
if($received_msg['from_number']==1111){ 
	$action_id = 11;
	
}else{

	  $action = $this->getSmsSwitchTable()->getSmsSwitchAction($received_msg['message']);
	$action_id = $action->action_id;
}
    // print_r($action);
// exit;
//then we use the action_id to Accept and Move on
//echo $action_id;
if($action_id<12){
		switch ($action_id) {
       	case "1":
	    $output = $this->register($received_msg['from_number'],$received_msg['message']); 
         // $output = "registration";
        break;  
    	case "2":
      $output = $this->test($received_msg['from_number'],$received_msg['message']); 
       	//testing($received_msg['from_number'],$received_msg['message']);
      	break;   
   		case "3":
		//claim_reward($received_msg['from_number'],$received_msg['message']);
		$output = $this->getSmsSettingsTable()->getSetMessage('reward_not_available')->value;
		//$output = "Be easy on the rewards, earn them first then request";
       	break;
		case "4":
		  //$output = "Invalid certificate";
		  $output = $this->verify_certificate($received_msg['from_number'],$received_msg['message']);
       	break;
		case "5":
		//take_survey($received_msg['from_number'],$received_msg['message']);
		$output = $this->getSmsSettingsTable()->getSetMessage('survey_not available')->value;
		 //$output = "Sorry we don't have this survey yet, we'll notify you when it is available";
       	break;
		case "6":
			// $output = 'hapa';
			// break;
		$message = $received_msg['from_number'];
		$output=$this->payments($message); 
       	break;
		case "7":
		$output=$this->checkSession($received_msg['from_number'],$received_msg['message']);     
      	break; 
		case "8":
		$output=$this->Sms_to_be_sent();     
      	break;
		case "9":
		$data=array(   
            'session'=>0,
            //'test_to_take'=>$testID,
            'progress'=>0
           );
    	$result = $this->getUserTable()->updateUser($data,$received_msg['from_number']);	
		$message=$this->getSmsSettingsTable()->getSetMessage('quit_session')->value; 
		$menu = $this->getSmsSettingsTable()->getSetMessage('menu_registered_user')->value;
		$output = $menu; 
		$output = $message.PHP_EOL.$output;  
      	break;
		case "10":
		$output= $this->check($received_msg['from_number']);
		//"Check the status of an ongoing process";
				//$current_session = $this->getUserTable()->get     
      	break; 	
		case "11":
			//echo "daily question";
			//exit();
  		$output = $this->dailyquestion($received_msg['from_number'],$received_msg['message']);
	   
      	break; 	
		}
		}
		else{
			$output = $action->message;
		}
		
	   $output = $this->send_output($sms_gateway_id,$output,$received_msg['from_number']);
	   $response = $this->getResponseWithHeader()
	   					->setContent($output);
        return $response;
    }

//lets check what is going on
public function check($from_number){
	$session = $this->getUserTable()->checkUserDetails($from_number); 
		$current_session = $session->session;
		if($current_session==0){
			$output = "You are not on any session currently";
			
		}else{
		
		if($current_session==1){
			$output = "You are not on any session currently";
			
		}else{
		
		
		if($current_session==2){
			//check progress
			//print_r("hapa");
			//exit();
	$progress = $session->progress;
		
	$current_test = $session->test_to_take;
	$message = $this->getSmsSettingsTable()->getSetMessage('current_session_message_for_a_test_taker')->value;
	
	
	//$message = "You are currently taking #Trial".$current_test."We are waiting for the following question";
	$QuestionDetails = $this->getQuestionTable()->getQuestion($progress);
   $nextquestion = $QuestionDetails->question_text;
   // return $next_question_id;
	//exit();
    //lets get the choices
   $Choices = $this->getChoicesTable()->getChoices($progress);
   

      $question_and_choices = PHP_EOL.$nextquestion.PHP_EOL.$Choices;
	  
	  $replace_with = array("#Trial".$current_test, $question_and_choices);
        $search_for   = array("{{current_test}}", "{{question}}");
		$output = str_replace($search_for, $replace_with, $message);
    
		
		
		}	
		}
		}
	return $output;
}


//one question per day

public function dailyquestion($from_number,$message){
	//lets get this cron user details
	if(is_numeric($message)){
		
	$user_details = $this->getUserTable()->checkUserDetails($from_number);
	//lets get the testID
	//$testID = $user_details->test_to_take;
 	$user_id = $user_details->id;
		//echo 'hapa';
		//exit();
		//activate the test
		$this->getQuizTable()->activate($message);
		//activate the invitations
		$quizID = $message;
		
		$quizdetails =  $this->getQuizTable()->getQuizDetails($quizID);
  	$class_id = $quizdetails->class_id;
		//we use the class id to get the course ID
	$courseID = $this->getClassTable()->getCourseID($class_id)->course_id;
		//return $courseID;
		//exit();
		//we get an array of phone numbers
	$invited_users = $this->getInvitationTable()->getInvitedUsers($courseID);
	
	//print_r($invited_users);
	//exit();
	//lets feed it into the table for messages to be sent out
	foreach ($invited_users as $key => $value) {
		$part = $message-4;
		$data=array(
		'message'=>'You have been invited to Marketing Basics Part '.$part.'. Please start the test by sending #Trial'.$message.' to 0708114735. Please note that the test will only be active from 9:00am to 7:00pm tonight. Good luck',
		'to'=>$value,
		'sender_id'=>$user_id,
		//'first_name'=>$first_name,
		//'last_name'=>$last_name,
		);
	//print_r($data);
	//exit();
	     $this->getSmsToBeSentTable()->createSmsToBeSent($data);
		return 'done';
	}
		
		
		//cron to send the invitations straight away.
	}else{
	
	$user_details = $this->getUserTable()->checkUserDetails($from_number);
	//lets get the testID
	$testID = $user_details->test_to_take;
 	$user_id = $user_details->id;
	
	//lets use the user_id and testId to get the question order
	$QuestionOrder = $this->getQuestionRandTable()->getQuestionOrder($testID,$user_id);
	

	//if($QuestionOrder==0){
		//test has not been started so 
		
	//}
	
  
  //check if it is the first question
  unset($QuestionOrder[0]);

	$message = '';
  if(empty($QuestionOrder[1])){
    $data=array(   
            'session'=>0,
            'test_to_take'=>0,
            'progress'=>0
            );
    $result = $this->getUserTable()->updateUser($data,$from_number);
	$message = "This is the last question.".PHP_EOL;
  }else{
  	//we need to get the next question to send out
  	foreach ( $QuestionOrder as $key=>$val ){

    $finalArray[] = $QuestionOrder[$key];

       }


//lets update the randomization
$status = 0;
$order = json_encode($finalArray);
$this->getQuestionRandTable()->updateRandomization($order,$testID,$user_id,$status);
 
  reset($QuestionOrder);
  $next_question_id = reset($QuestionOrder);
 
   $QuestionDetails = $this->getQuestionTable()->getQuestion($next_question_id);
   $nextquestion = $QuestionDetails->question_text;  	
  	//lets get the right answer
  	//getChoices4DailyQuestion
	$Choices = $this->getChoicesTable()->getChoices4DailyQuestion($next_question_id);  	
  	
  	//$right_answer = $this->getChoicesTable()->getRightChoice($next_question_id)->answer_text;
	
	//lets get who to send to, i.e. the invited users
	$quizdetails =  $this->getQuizTable()->getQuizDetails($testID);
  	$class_id = $quizdetails->class_id;
		//we use the class id to get the course ID
	$courseID = $this->getClassTable()->getCourseID($class_id)->course_id;
		//return $courseID;
		//exit();
		//we get an array of phone numbers
	$invited_users = $this->getInvitationTable()->getInvitedUsers($courseID);
	
	//print_r($invited_users);
	//exit();
	//lets feed it into the table for messages to be sent out
	foreach ($invited_users as $key => $value) {
		$data=array(
		'message'=>$message.$nextquestion.PHP_EOL.$Choices,
		'to'=>$value,
		'sender_id'=>$user_id,
		//'first_name'=>$first_name,
		//'last_name'=>$last_name,
		);
	//print_r($data);
	//exit();
	     $this->getSmsToBeSentTable()->createSmsToBeSent($data);
		
	}
	//echo "done";
	//exit();
 }
	
	
		//echo 'tuko hapa';
		//exit();
		
	//what we need to do:
	//check if the daily question has been started, if not 
}
}

//lets pull what has to be sent out
public function Sms_to_be_sent(){
	//lets get pending smses to be sent
		
	$PendingSmses = $this->getSmsToBeSentTable()->getPendingSmses();	
	
	//echo "hapa";
	//exit();
	$PendingInvites = $this->getInvitationTable()->getPendingInvites();
	//we need to know the test in the courses first
	
	
	$newarray = array();
	
	foreach ($PendingInvites['invitation'] as $key1 => $value) {
		// print_r($value);
		// exit();
		$course_classes = $this->getClassTable()->getClasses($value);
		//lets get tests
		if($course_classes !=0){
		foreach ($course_classes as $key => $value) {			
			
		$testIds = $this->getQuizTable()->getQuizdetail($value);
			if($testIds !=0){
			foreach ($testIds as $key => $value) {
				
				array_push($PendingInvites['invitation'][$key1],$value);
				//update invitation status
				$result = $this->getInvitationTable()->updatestatus($PendingInvites['invitation'][$key1]);
				
				
			}			
			}
		}
		}
		//if($course_classes->class_id > 0){
			
						
			
		//}
	}
	
	array_push($PendingInvites,$PendingSmses);
	
	//$course_tests = $this->getCourseTable()->getTests($PendingInvites['invitation'][2]);
	
	//return $newarray;
	return $PendingInvites;
	
	
}


//payment function

public function payments($message){

		$xplode=explode(" ",$message,2);
		 //$exploded = explode(" ", $message, 3);
		 $transcation_id=$xplode[0];
		 
		 $xplode=explode("Ksh",$xplode[1],2);
		 $xplode=explode(".", $xplode[1],2);
		 $amount = $xplode[0];
		 $xplode=explode("254", $xplode[1],2);
		 $xplode=explode(" ", $xplode[1],2);
		 $phone_number = "+254".$xplode[0];
		 $phone = $phone_number;

		$payment = $amount;
		$data=array(
		'transcation_id'=>$transcation_id,
		'amount'=>$payment,
		'phone_number'=>$phone_number,
		//'first_name'=>$first_name,
		//'last_name'=>$last_name,
		);
	//print_r($data);
	//exit();
	     $paid=$this->getPaymentsTable()->saveTransaction($data);
		 
		 //print_r($paid);
		 //exit();
		 //if($amount){
		 	//$amount= $data['amount'];
		 	//$amount = $xplode[0];
		 	//$amount = $payment;
		 	$paid->amount;
			//exit();
		 	$output=array($phone_number);
			 
			 //$message="Your Payment has been recieved. Thank you";
			 $phone_number = "+254".$xplode[0];
			 
			 $user_id = $this->getUserTable()->checkUserDetails($phone_number)->id;
			 // echo $user_id;
			 // exit();
			 //$certificate = $this->getUserCertificatesTable()->
			 
			$certificates=$this->getUserCertificatesTable()->user_certificate($user_id);
			 // print_r($certificates);
			 // exit();
			 //print_r($amount);
			 //exit();
			 //foreach ($certificates as $certificate) {
			 if($certificates->amount == $paid->amount){
			 	
				 $message = $this->getSmsSettingsTable()->getSetMessage('payment_equal_to certificate_amount')->value;
	
				$replace_with = array($certificates->certificate_code);
        		$search_for   = array("{{cert_code}}");
				$message = str_replace($search_for, $replace_with, $message);
				
			 	//$message = "Your payment has been received. Your certificate:".$certificates->certificate_code." is now active";
				 //update the certificate status
				 
				 $this->getUserCertificatesTable()->updatestatus($certificates->id);
			 	
			 }
			 if($certificates->amount<$amount){
			 	$overpayment = $amount-$certificates->amount;
				 
				 $message = $this->getSmsSettingsTable()->getSetMessage('payment_more_than_certificate_amount')->value;
	
				$replace_with = array($underpayment, $certificates->certificate_code);
        		$search_for   = array("{{overpayment}}", "{{cert_code}}");
				$message = str_replace($search_for, $replace_with, $message);
				 
			 	//$message = "Your payment has been received. We noticed you overpaid it by Ksh. ".$overpayment." and have credited your account for future certificates. Congratulations, ".$certificates->certificate_code." is now valid and active";
				 //update the certificate status
				 
				 $this->getUserCertificatesTable()->updatestatus($certificates->id);
			 	
			 }if($certificates->amount>$amount){
			 	$underpayment = $certificates->amount-$amount;	
				$message = $this->getSmsSettingsTable()->getSetMessage('payment_less_than_certificate_amount')->value;
	
				$replace_with = array($underpayment, $certificates->certificate_code);
        		$search_for   = array("{{underpayment}}", "{{cert_code}}");
				$message = str_replace($search_for, $replace_with, $message);
				
				
			 	//$message = "Your payment has been received but is short of Ksh. ".$underpayment." Your certificate ".$certificates->certificate_code." will be valid once your full payment is recieved. Thanks for using Akengo";
				 //update the certificate status
				 
				 //$this->getUserCertificatesTable()->updatestatus($certificates->id);
			 	
			 }
			 	//print_r($certificate);
				 array_push($output,$message,$phone_number);
				 
			 //}
			
			$return = array();
			array_push($return,array('user_cert'=>$output));
			return $return;
			//print_r($return);
			//exit();
			 //array_push($output,$message);
			 

			// return $user_id;
		 //}
		 
	
}




    public function getResponseWithHeader()
    {
        $response = $this->getResponse();
        $response->getHeaders()
                 //make can accessed by *  
                 ->addHeaderLine('Access-Control-Allow-Origin','*')
                 //set allow methods
                 ->addHeaderLine('Access-Control-Allow-Methods','POST PUT DELETE GET');
         
        return $response;
    }

//let us send out the output
	public function send_output($sms_gateway_id,$output,$from_number){
             
		//If we are using SMSSync id=1 and we do the following
	if($sms_gateway_id==1){
        
		    if (is_array($output)){
		    	//print_r($output);
		    	//exit();
				if(!empty($output[1]['winners'])){
					
			$records[] = array('message'=> $output[0], 'to'=>$from_number);
	  
					foreach ($output[1]['winners'] as $key => $data) {
						$key = $key+1;
						
		$message = $this->getSmsSettingsTable()->getSetMessage('qualified_for_airtime_reward')->value;
	
		$replace_with = array($key, '#Trial'.$output[4],$output[2]);
        $search_for   = array("{{position}}", "{{test_code}}", "{{reward}}");
		$message = str_replace($search_for, $replace_with, $message);			
					
						
         array_push($records, array('message'=>$message, 'to'=>$data[2]
      ));
	  array_push($records, array('message'=>$output[2].'#0'.substr($data[2],-9), 'to'=>'140'));
	  $output[2] = $output[2]-200;
           # code...
        }
				
			//array_push($records, array('message'=>$output[0], 'to'=>$from_number));
					
				}else{
					if((!empty($output['invitation']))||(!empty($output['0']['sms_to_be_sent']))){
					//		print_r($output);
					//	exit(); 
						//echo 'invitation';
						//exit();
			$records = array();
					foreach ($output['invitation'] as $key => $data) {
						//$key = $key+1;
		$message = $this->getSmsSettingsTable()->getSetMessage('invitation_to_course')->value;
	
		$replace_with = array($data[3], "#Trial".$data[4]);
        $search_for   = array("{{course_name}}", "{{test_code}}");
		$message = str_replace($search_for, $replace_with, $message);				
						
						
      $records[] = array('message'=>$message, 'to'=>$data[0]);
	  
           # code...
         }
		foreach ($output['0']['sms_to_be_sent'] as $key => $data) {
						//$key = $key+1;
				
	 $this->getSmsToBeSentTable()->updatestatus($data[2]);			
				
	//lets send these things through africastalking
		
			//bazinga begins
		// Lets specify login credentials
$username    = "Craig";
$apiKey      = "b4604f7cf3b1b3b21681107e820e6520e18d9143d0ec6f1aea4d56eccc0edf98"; 

// Specify the numbers that you want to send to in a comma-separated list
// Please ensure you include the country code (+254 for Kenya in this case)
/*$recipients = "+254729861869,+254728355429,+254728833181,+254208102935,+254723384144,+254756901853,+254721437425";

//$number;
// And of course we want our recipients to know what we really do
$message = "Kimaiyo sworn in as Inspector General.";*/
	$message = $data[0];
//$receipient = $data[1];

$recipients = $data[1];
// And of course we want our recipients to know what we really do
/*$message = "UAP AfyaImara test SMS";*/

require_once('AfricasTalkingGateway.php');

// Create a new instance of our awesome gateway class
$gateway  = new AfricasTalkingGateway($username, $apiKey);

// Thats it, hit send and we'll take care of the rest
$results  = $gateway->sendMessage($recipients, $message);
if ( count($results) ) {
  // These are the results if the request is well formed
  foreach($results as $result) {
  	echo "<br>";
	echo " Number: " .$result->number;
	echo " Status: " .$result->status;
	//echo " Cost: "   .$result->cost."\n";
  }
} else {
	// We only get here if we cannot process your request at all
	// (usually due to wrong username/apikey combinations)
  	echo "Oops, No messages were sent. ErrorMessage: ".$gateway->getErrorMessage();
}


		//bazinga ends		
				//exit();
      //$records[] = array('message'=>$data[0], 'to'=>$data[1]);
	 
           # code...
         }
			exit();
			
				//print_r($records);
				//exit();
			//array_push($records, array('message'=>$output[0], 'to'=>$from_number));
					
	}else{
					if(!empty($output[0]['user_cert'])){
						
		//print_r($output);
		//exit();
		//update status
		$records = array();
		$message = '';
				foreach ($output[0] as $key => $data) {
						//$key = $key+1;
						
		$records[]= array( 'message' => $data[1], 'to' => $data[2]);
						//$message = $message." ".$key.'='.$data;
      
		
           # code...
         }
		//$this->getUserCertificatesTable()->getCertificate
		//$records[]= array( 'message' => $message, 'to' => '+254723384144');
		
		//$records[]= array( 'message' => "Payment has been received and your certificate has been activated", 'to' => $from_number);
		
		
	}	else{
				
         $records = array();         
         foreach ($output as $data) {
          array_push($records, array('message'=>$data, 'to'=>$from_number));
           # code...
         }
				}
					
				}			
				
				}  
        }else{
		    $records[]= array( 'message' => $output, 'to' => $from_number);	
			  }
        $sms_array= array();
				$sms_array[] = array('success'=>"true",'secret'=>"akengo1234",'task'=>"send",'messages'=>$records);
				$payload= array('payload'=>$sms_array[0]);
				//header('content-type: application/json; charset=utf-8');
				//echo json_encode($payload);
		
return json_encode($payload);
		
	}
	//If we are using Africastalking we do the following
	if($sms_gateway_id==2){
		//we will write this code from Africastalking documentation
		//
		
	}
	/*future sms gateway will be setup here to be used
	 if($sms_gateway_id==X){
		we will write this code from Africastalking documentation
 		
	}*/

	else{
		//
	}
		
	}	
	//lets take a test

  public function test($from_number,$message){

  $user_details = $this->getUserTable()->checkUserDetails($from_number);
  //return $user_details;
  //exit;
  $user_exists = $user_details->from_number;
  if($user_exists >0){
    //set test session to test and start the progress

    //is the test private or not
    //if private you check if the user if invited
    $progress = $user_details->progress;
    //lets check if the user has started the test
    if($progress<1){
      //get test question id
  $testID = $this->getTestID($message);

    // return $testID;
    // exit();
    //getSetting on whether users are allowed to take a test more than once. 0 for not allowed, 1 for allowed
    
    $quizdetails =  $this->getQuizTable()->getQuizDetails($testID);
  //return $quizdetails->id;
  //exit();
  if($quizdetails->published==0){
  	$output = $message.' has not yet been published';
	  return $output;
	  
  	
  }
  
  if($quizdetails->id==0){
    // if the test is not available
	///print_r($quizdetails);
	//exit();
    $output = $this->getSmsSettingsTable()->getSetMessage('no_test_with_that_id')->value;
	//$lastID = $quizdetails->largest;
	
	//print_r($lastID);
	//exit();
	
	//$quizlastID =  $this->getQuizTable()->getfiveRandomQuizes();
    //$output = $action->prefix;
    //create log
			$data=array(
                            'user_id'=>$user_details->id,
                            'activity'=>22,
                            'quiz_id'=>$testID,
                            'message_received'=>$message
                        ); 
  		//create data points
  		$log = $this->getUserSmsInteractionsTable()->createActivity($data);
		//end of log creation
    
  }else{
  //if we first randomize the order in which we are going to serve the questions
    //return $user_details->id;
  //exit();
  //check how many times a user can take a test
  $test_permission = $this->getSmsSettingsTable()->getSetMessage('how_many_times_a_user_can_take_a_test')->value;
  //return $test_permission;
  //exit();
$taken = $this->getUserSmsInteractionsTable()->getCompletedExamInteraction($user_details->id,$testID);

//print_r($taken);
//exit();

 if($taken[0]>=$test_permission ){
		$not_allowed_message = $this->getSmsSettingsTable()->getSetMessage('you_are_not_allowed_to_retake_this_test')->value;
			
			//lets do replaces
		if($test_permission==1){
			$times = 'once';
		}else{
			$times = $test_permission.' times';
		}
		
		//print_r($taken);
		//exit();
		//lets deal with timezone issues
		$Date = $this->getLocalTime($taken[1]->timestamp);
		
		//lets give allowance for demo
		if($message=='#trial3'){
			$message = 'the demo';
		}
			
		$replace_with = array($message, $Date, $taken[1]->score,$times);
        $search_for   = array("{{test_id}}", "{{date}}", "{{score}}","{{times}}");
		$output = str_replace($search_for, $replace_with, $not_allowed_message);
		
		//return $output;
		//exit();
			
			
		}
		
	
	//if there is not set test permission we go on
	else{
  
   $randomizedorder = $this->rand_test($user_details->id,$testID,$quizdetails->id);

	$number_of_questions_in_test = $this->getSmsSettingsTable()->getSetMessage('number_of_questions_in_test')->value;	
	
	 $number_of_questions_in_test = str_replace("{{total_number}}", count($randomizedorder), $number_of_questions_in_test); 
	//print_r(count($randomizedorder));
	//exit();
  //return $randomizedorder;
  //exit();
	if($randomizedorder == 0){
	$output =  $this->getSmsSettingsTable()->getSetMessage('no_questions_set')->value;
  
  $output = str_replace("{{test}}", $message, $output); 
  //exit();
  //create log
			$data=array(
                            'user_id'=>$user_details->id,
                            'activity'=>23,
                            'quiz_id'=>$testID,
                            'message_received'=>$message
                        ); 
  		//create data points
  		$log = $this->getUserSmsInteractionsTable()->createActivity($data);
		//end of log creation
		 
}else{
   	
   //lets get the introduction text
   if(empty($output)){
   $output = array();
   }
    $intro_text = $quizdetails->intro_text;
    //echo $quizdetails->id;
    $QuestionDetails = $this->getQuestionTable()->getQuestion($randomizedorder[0]);
    $firstquestion = $QuestionDetails->question_text;
    //$firstquestionID = $QuestionDetails->id;
    //echo $firstquestionID." ".$randomizedorder[0];
   //exit();
    //lets get the choices
   $Choices = $this->getChoicesTable()->getChoices($randomizedorder[0]);
   
   //since we have everything together, let's update the progress to 1
   $data=array(   
            'session'=>2,
            'test_to_take'=>$testID,
            'progress'=>$randomizedorder[0]
            );
    $this->getUserTable()->updateUser($data,$from_number);
	
	//print_r($output);
	//exit();
	//if(!$output){
		$output = array();
	//}
	array_push($output,$intro_text);
	array_push($output,$number_of_questions_in_test.PHP_EOL.$firstquestion.PHP_EOL.$Choices);
    //$output = $intro_text.PHP_EOL." 1.".$firstquestion.PHP_EOL.$Choices;
	//create log
			$data=array(
                            'user_id'=>$user_details->id,
                            'activity'=>6,
                            'quiz_id'=>$testID,
                            'message_received'=>$message
                        ); 
  		//create data points
  		$log = $this->getUserSmsInteractionsTable()->createActivity($data);
		//end of log creation
  }
  }
  }
  }
if($progress>0){
 $selected_option = '';
 $testID = $user_details->test_to_take;
 $user_id = $user_details->id;
 $question_id = $progress;
 //Lets get all the choices possibilities first

 $ChoicesData = $this->getChoicesTable()->getChoicesData($question_id);
 //$keys = '';
 // return $ChoicesData;
// exit();

if(empty($ChoicesData)){
	$selected_option = $message;
}
else{
 $message = strtolower($message);
 foreach ($ChoicesData as $key => $value) {
 	//check if they are equal
 	
 	
 	if((trim(strtolower($key)) == $message)){
 		foreach ($value as $key1 => $value1){
 		$selected_option = $value1[0]; 
		}	
		//if they fail to map then selected option is empty but we don't stop there, 
		//do a second check to check if the user sent the value instead
 	}if(empty($selected_option)){ 		
 		foreach ($value as $key1 => $value1){
 		if((trim(strtolower($value1[1])) == $message)){
 		$selected_option = $value1[0];
		} 
		}	
	}
    }
}
 
 
if(empty($selected_option)){
 	//if the validation is not passed then we return the user with the question again
 		$error_message = $this->getSmsSettingsTable()->getSetMessage('selected_choice_not_one_of_the_options')->value;;
 		$QuestionDetails = $this->getQuestionTable()->getQuestion($question_id);
        $nextquestion = $QuestionDetails->question_text;
   // return $next_question_id;
	//exit();
    //lets get the choices
        $Choices = $this->getChoicesTable()->getChoices($question_id);
		//create log
			$data=array(
                            'user_id'=>$user_details->id,
                            'activity'=>8,
                            'quiz_id'=>$testID,
                            'question_id'=>$question_id,
                            'message_received'=>$message
                        ); 
  		//create data points
  		$log = $this->getUserSmsInteractionsTable()->createActivity($data);
		//end of log creation

        $output = $error_message.PHP_EOL.$nextquestion.PHP_EOL.$Choices;
		return $output;
 }else{
 
 // return $selected_option;
 // exit();
 
  //$selected_option
  //we get the answer to the previous question

  $data=array(    
    
            'quiz_id'=> $testID,
            'user_id'=> $user_id,
            'question_id'=>$question_id,
            'answer_id'=>$selected_option
            );
        //print_r($data);
  //feed in the response for the previous question
  $this->getQuestionResponsesTable()->createResponse($data);
  
  	//create log
			$data=array(
                            'user_id'=>$user_details->id,
                            'activity'=>7,
                            'quiz_id'=>$testID,
                            'question_id'=>$question_id,
                            'message_received'=>$message
                        ); 
  		//create data points
  		$log = $this->getUserSmsInteractionsTable()->createActivity($data);

   // exit();
  $QuestionOrder = $this->getQuestionRandTable()->getQuestionOrder($testID,$user_id);
  //array_splice($QuestionOrder, count($QuestionOrder),-1);
  // print_r($QuestionOrder);
  // exit();
  unset($QuestionOrder[0]);
// return $QuestionOrder[1];
// exit();
  if(empty($QuestionOrder[1])){
    $data=array(   
            'session'=>0,
            'test_to_take'=>0,
            'progress'=>0
            );
    $result = $this->getUserTable()->updateUser($data,$from_number);
	//lest go to the marker now
	//$output = "hapa";
	
	//create log
			$data=array(
                            'user_id'=>$user_details->id,
                            'activity'=>9,
                            'quiz_id'=>$testID,
                            //'question_id'=>$question_id,
                            //'message_received'=>$message
                        ); 
  		//create data points
  		$log = $this->getUserSmsInteractionsTable()->createActivity($data);
		//end of log creation
	
	//this will give the score
	$output = array();
	array_push($output,$this->SmsMarker($user_id,$testID));
	
	//check if test has airtime reward af the user qualifies for it user qualifies for a reward
	$quizdetails =  $this->getQuizTable()->getQuizDetails($testID);
	if((!empty($quizdetails->airtime_reward))&&($quizdetails->airtime_reward_status<1)){
		//quiz has a test reward so we check if all those who had been invited, have completed
		//we need the class ID in order to go to the next step
		$class_id = $quizdetails->class_id;
		//we use the class id to get the course ID
		$courseID = $this->getClassTable()->getCourseID($class_id)->course_id;
		//return $courseID;
		//exit();
		//we get an array of phone numbers
		$invited_users = $this->getInvitationTable()->getInvitedUsers($courseID);
		// if($invited_users==0){
			// return $output;
			// exit();
		// }
		//for each phone number, 
		//array_push($output,$invited_users);
		//return $output;
		//exit();
		
		$incomplete = 0;
		$rank = array();
		foreach ($invited_users as $key => $value) {
			$userPhone = $this->getUserTable()->checkUserDetails($value);

			//does the user exist
			if($userPhone->id>0){
			
			//we get the user id and check if he/she has completed the exam
			
			$completed_users = $this->getUserSmsInteractionsTable()->getScore($userPhone->id,$testID);
			//once we get the first person who has not completed the exam, we break and send back message, you recieve reward if you win
			$completed = $completed_users->user_id;
			if($completed==0){
				$incomplete = $incomplete+1;
				//$reply = "You will be notified if you win airtime";
				//array_push($output,$reply);
				return $output;
				exit();
			}
		
			else{
				array_push($rank,$userPhone->id = array($completed_users->score,$completed_users->timestamp,$value));
								//we rank users as we progress
				
				
				
			}
			
			
			}else{
				$incomplete = 1;
				$reply = "You will be notified if you win airtime";
				//array_push($output,$reply);
				//exit();
		}
		
			
		}
		if($incomplete==0){
			//array_push($output,$rank);
			//return $output;
			
			//we run the lottery
			//get the number of users who qualify for the reward
			$number_of_winners = $quizdetails->no_of_people;
			//get the top 3 scorers:
			//rank according to score
			foreach ($rank as $key => $row) {
    $score[$key] = $row[0];
    $dates[$key] = $row[1];
     }
			array_multisort($score, SORT_DESC, $dates, SORT_ASC, $rank);
			//$winners = array();
		$winners = array_slice($rank, 0, $number_of_winners);
		//$winners = 
			array_push($output,array('winners' => $winners));
			array_push($output,$quizdetails->airtime_reward,$quizdetails->quiz_name,$quizdetails->id);
					}else{
					
						$reply = "You will be notified if you win airtime";
				array_push($output,$reply);
					}
		//lets put a note that the aitime has been won
		  $data=array(   
            
            'airtime_reward_status'=>1
            );
         // print_r($quizdetails->id);
		 // exit(); 
    $result = $this->getQuizTable()->updateRewardStatus($data,$quizdetails->id);
	  // echo 'hapa';
			// exit();
		if($result){
		
		}
		//check the timestamp to confirm when these guys completed the test
		//lets declaire the final winners
		//$winners = array();
		
	}
	
	//lets check if the user qualifies for a reward.
    //$output = 'You will get your results shortly';
	// we should go to the merker now

	
	return $output;
  }else{

foreach ( $QuestionOrder as $key=>$val ){

    $finalArray[] = $QuestionOrder[$key];

}


  //lets update the json object
$status = 0;
$order = json_encode($finalArray);
$this->getQuestionRandTable()->updateRandomization($order,$testID,$user_id,$status);
  //print_r($QuestionOrder);
  //exit();
 
  // foreach ($QuestionOrder as $key => $value) {
  //   $key[$key] = $key;
  //   $value[$key] = $value;
  // }
  reset($QuestionOrder);
  $next_question_id = reset($QuestionOrder);
  //print_r($next_question_id);
  //Next question number
 // $no = key($QuestionOrder)+1;
  //echo $no;
  //print_r($key[]);


  
  //$next_question_id = $QuestionOrder[1];


   $QuestionDetails = $this->getQuestionTable()->getQuestion($next_question_id);
   $nextquestion = $QuestionDetails->question_text;
   // return $next_question_id;
	//exit();
    //lets get the choices
   $Choices = $this->getChoicesTable()->getChoices($next_question_id);
   
   //since we have everything together, let's update the progress to 1
   $data=array(   
            'session'=>2,
            'test_to_take'=>$testID,
            'progress'=>$next_question_id
            );
    $result = $this->getUserTable()->updateUser($data,$from_number);
    if($result){


      $output = $nextquestion.PHP_EOL.$Choices;
    }

    
 } 


}
}
  }
//if the user has started the test then we go on as per the progress
    else{
    	
   $intro_message = $this->getSmsSettingsTable()->getSetMessage('register_before_test')->value; 
		
		
   $first_question = $this->getSmsSettingsTable()->getSetMessage('appl_welcome_message')->value;
  
   //$referred = $message;
  //$first_question = $this->register($from_number,$message);
  $id = $this->getUserTable()->createUserWithReferral($from_number,$message);
  
   $data=array(
                            'user_id'=>$id,
                            'activity'=>1,
                            //'progress'=>1,
                            'message_received'=>$message
                        );  
  		
  		$log = $this->getUserSmsInteractionsTable()->createActivity($data);
   
  $output = array();
  array_push($output,$intro_message." ".$first_question);
  //$output = "hapa";
    }
    return $output;
  }

//Lets mark exams

public function SmsMarker($user_id,$testID){
	//lets get question IDs first:
	
	
	$questionIDs = $this->getQuestionTable()->getQuestionIDs($testID);
	//get the response for the user for the particular test
	$no_of_questions = count($questionIDs);
	$no_of_correct_responses = 0;
	foreach ($questionIDs as $key => $value) {
		//get the user response for that question id
		$user_response = $this->getQuestionResponsesTable()->getresponse($value,$user_id)->answer_id;
		
		//get the right question and compare
		
		$right_answer = $this->getChoicesTable()->getRightChoice($value)->id;
		if($right_answer==0){
			//when there is not set correct answer
		}else{
	// return $right_answer;
	// exit();
		if( $user_response == $right_answer){
 		$no_of_correct_responses = $no_of_correct_responses+1;
		} 
		}

 }
	$percentage = $no_of_correct_responses / $no_of_questions;
	if($no_of_correct_responses>0){
	$percentage = $percentage * 100;
	
	$percentage = number_format($percentage, 0, '.', '');
	}else{
		$percentage = 0;
	}
	//let us feed it the data to the user assignment table
	
	//lets log the marking
	
	
	//lets log the marking
	$data=array(
                            'user_id'=>$user_id,
                            'activity'=>10,
                            'score'=>$percentage, 
                            'quiz_id'=>$testID,
                            //'message_received'=>$message
                        ); 
	$log = $this->getUserSmsInteractionsTable()->createActivity($data);
	
	if($percentage>=50){
		
		
		$pass = 1;
		
		//check if the course has a certificate to be issued
		
		$class_id = $this->getQuizTable()->getQuizDetails($testID)->class_id;
	
	//use the class Id to get course id
	    $courseID = $this->getClassTable()->getCourseID($class_id)->course_id;
		$certificate = $this->getCertificatesTable()->checkCertificateAvailability($courseID);
		if($certificate->course_id==0){
			//the course does not have a certificate so what we do is we give the message for completion
		$message = $this->getSmsSettingsTable()->getSetMessage('course_without_certificate')->value;
			 
		$replace_with = array($no_of_correct_responses, $no_of_questions,$percentage);
        $search_for   = array("((no_of_correct_responses.}}", "{{no_of_questions}}","{{percentage}}");
		$output = str_replace($search_for, $replace_with, $message);
		
			 
	}else{
		
		$amount = $certificate->value;
		
	    $cert="#CERT".$user_id.$testID;
	
	
	
	
	    $message = $this->getSmsSettingsTable()->getSetMessage('certificate_qualification')->value;
	
		$replace_with = array($no_of_correct_responses, $no_of_questions,$cert,$percentage,$amount);
        $search_for   = array("((no_of_correct_responses.}}", "{{no_of_questions}}", "{{cert_code}}","{{percentage}}","{{amount}}");
		$output = str_replace($search_for, $replace_with, $message);
	
	//$output= "Congratulations, you got ".$no_of_correct_responses." out of ".$no_of_questions." which is .".$percentage."%. You have qualified for ".$cert.". Please pay Ksh. ".$amount." via MPESA to Buy Goods no. 964710 to activate it"; 
	//$this->getQuestionResponsesTable()->getresponse();
		}
	}else{
		//echo 'hapa';
		//exit();
		$pass = 0;
		$message = $this->getSmsSettingsTable()->getSetMessage('score_below_pass_mark')->value;
	
		$replace_with = array($no_of_correct_responses, $no_of_questions,$percentage);
        $search_for   = array("((no_of_correct_responses.}}", "{{no_of_questions}}","{{percentage}}");
		$output = str_replace($search_for, $replace_with, $message);
		
			$data=array(			
							'assignment_id'=>$testID,
                            'user_id'=>$user_id,
                            'status'=>$pass,
                            'score'=>$percentage, 
                            //'completed_at' => now(),
                            //'quiz_id'=>$testID,
                            //'message_received'=>$message
                        ); 
						
	$result = $this->getUserAssignmentTable()->createScore($data);
		if($result){
		return $output;
		}
		//$output= "Seems you will need more effort, you got ".$no_of_correct_responses." out of ".$no_of_questions." which is ".$percentage."%. Thanks for using akengo."; 
	}
	
	$data=array(			
							'assignment_id'=>$testID,
                            'user_id'=>$user_id,
                            'status'=>$pass,
                            'score'=>$percentage, 
                            //'completed_at' => now(),
                            //'quiz_id'=>$testID,
                            //'message_received'=>$message
                        ); 
						
	$result = $this->getUserAssignmentTable()->createScore($data);
	
	$class_id = $this->getQuizTable()->getQuizDetails($testID)->class_id;
	
	//use the class Id to get course id
	$courseID = $this->getClassTable()->getCourseID($class_id)->course_id;
	//use course Id to get institution ID
	//$ID = $this->getClassTable()->getCourseID($class_id)->course_id;
	
	if($certificate->course_id!=0){
			//the course does not have a certificate so what we do is we give the message for completion
		$cert="#CERT".$user_id.$testID;
	$userCertdata = array(			
							'user_id'=>$user_id,
                            'certificate_code'=>$cert,
                            'status'=>0,
                            'course_id'=> $courseID,
                            'amount'=>$amount, 
                            //'completed_at' => now(),
                            //'quiz_id'=>$testID,
                            //'message_received'=>$message
                        ); 
	//
	$result = $this->getUserCertificatesTable()->createCertificate($userCertdata);
		
			 
		}
	
	
	
	
	return $output;
	
}


//lets deal with server time issues
public function getLocalTime($timestamp){
//convert current timestamp to unix timestamp	
$newtime = strtotime($timestamp);
//do the magic by adding the offset between server time('America/Denver') and ('Africa/Nairobi')
$newadjustedtime = date('l jS \of F Y h:i A',strtotime($timestamp) + 9 * 3600);
return $newadjustedtime;
//exit();

}

    //this function is to be removed later

  public function rand_test($user_id,$testID,$quizID){
//get all questionIDs

  $randomizedorder = $this->getQuestionTable()->getQuestionIDs($quizID);
  //return $randomizedorder;
  //exit();
if($randomizedorder == 0){
	return $randomizedorder;
  //exit();
}else{
shuffle($randomizedorder);
//return $user_id;
//exit();
 
$data=array(
            'user_id'=>$user_id,
            'quiz_id'=>$testID,
            'order'=>json_encode($randomizedorder)
        );
//feed in the database
$result = $this->getQuestionRandTable()->createRandomization($data);
//return $result;
//exit();
if($result){
return $randomizedorder;
}
  }
  }

//lets verify a certificate
public function verify_certificate($from_number,$message)
    {
    	//get certificate details
       $certDetails =$this->getUserCertificatesTable()->getCertUserID($from_number,$message);
	  
		
	   $certUserID = $certDetails->user_id;
	   //print_r($certDetails);
	   
	   //if we don't have a user_id with that certificate ID, then certificate is invalid
	  if($certUserID==0){
	   	
	   	$invalid_cert_message = $this->getSmsSettingsTable()->getInvalidCertMessage()->value;
		//We do a string replace to get the output message to be sent back
		$output = str_replace("{{cert_id}}", $message, $invalid_cert_message);		   
	   }else{
	   	//Get user's details using the $certUserID	 
	    $course_id = $certDetails->course_id;	
	   	$user_details = $this->getUserTable()->getUserDetails($certUserID);
		// print_r($user_details);
		// exit();
// 		
		$course_details= $this->getCourseTable()->getCourseDetails($course_id);
		
		$institutionID = $course_details->institution_id;
		// print_r($institutionID);
		// exit();
		
	//get institution details
		$institution_details = $this->getUserTable()->getUserDetails($institutionID);
	
	//get course details
		//$output = $institution_certificate_details->course_id;
	  //$course_details = $this->getCourseTable()->getCourseDetails($institution_certificate_details->course_id);
		//Get Valid Certificate Message from Message Settings
		
		$valid_cert_message =  $this->getSmsSettingsTable()->getValidCertMessage()->value;
		//lets get the local date
		$Date = $this->getLocalTime($certDetails->timestamp);
		//let do some string replace magic in our template
		// $replace_with = array($user_details->first_name, $user_details->last_name);
        // $search_for   = array("{{first_name}}", "{{last_name}}", "{{cert_id}}");
		// $output = str_replace($search_for, $replace_with, $valid_cert_message);
		
		$replace_with = array($user_details->first_name, $user_details->last_name, $message,$institution_details->first_name." ".$institution_details->last_name,
		$course_details->course_name,$Date);
        $search_for   = array("{{first_name}}", "{{last_name}}", "{{cert_id}}","{{PROVIDER}}",
		"{{COURSE NAME}}","{{DATE}}");
		$output = str_replace($search_for, $replace_with, $valid_cert_message);
		
		}  
	    
		return $output;
        //return $this->getResponse()->setContent(Json::encode($data));
    }
    
   public function getTestID($message){
    //get the test prefix
    $prefix=$this->getSmsSwitchTable()->getPrefix(2)->prefix;
    $prefix_length = strlen($prefix);
    $test_id = substr($message, $prefix_length);
    //getPrefix

    //$prefix = $action->prefix;
    //count the test prefix
    //delete the number of characters from the from
return $test_id;

   } 

   public function register($from_number,$message){
       
	     	//check user is registered
			$user_details = $this->getUserTable()->checkUserDetails($from_number);
			$user_exists = $user_details->from_number;
                                  
        if($user_exists >0){
                        	 
	        $progress = $user_details->progress;
			// return $progress;
			// exit();
			//progress used to determine the step we are at in the switch		
			switch ($progress) {
   			case 1: 
				//return 'hapa';
				//exit();
			$output=$this->getnationalID($from_number, $message,$user_details->id);
        	//welcome_request_first_name(); 
       		break;
			case 2:
    		$output=$this->thankyouMsg($from_number, $message,$user_details->id);
			break;
			
    		default:
			//create activity
			//create log
			$data=array(
                            'user_id'=>$user_details->id,
                            'activity'=>24,
                            //'quiz_id'=>$testID,
                            'message_received'=>$message
                        ); 
  		//create data points
  		$log = $this->getUserSmsInteractionsTable()->createActivity($data);
		//end of log creation
			
			$output=$this->getSmsSettingsTable()->getSetMessage('thank_you_already_registered')->value;
       		//$output=("Thank you, you are already Registered");
      		break;
			}
			return $output;
				
			}                      //we start session and insert user to db
                            //then assign progress=1
                            //then get first registration question


else{

  //create user
                        
		$id = $this->getUserTable()->createUser($from_number);
  //log activity
  // return $id;
  // exit();
    $data=array(
                            'user_id'=>$id,
                            'activity'=>1,
                            //'progress'=>1,
                            'message_received'=>$message
                        ); 
  		//create data points
  		$log = $this->getUserSmsInteractionsTable()->createActivity($data);
		         
    $first_question=$this->getSmsSettingsTable()->getSetMessage('appl_welcome_message')->value;
			
    }
      return $first_question;
						
		}
  



    public function checkSession($from_number,$message){


$user_details = $this->getUserTable()->checkUserDetails($from_number);
			$user_exists = $user_details->from_number;
                   
                        if($user_exists >0){
$user_session = $this->getUserTable()->checkUserDetails($from_number);
$session = $user_session->session;
//return $session;
//exit();
        //$session=$this->getUserTable()->chec($from_number);
        
	switch ($session) {
       
       case "1":
       $output=$this->register($from_number,$message,$user_session->id);
     break;    
        case "2":
       $output= $this->test($from_number,$message);
    break;    
        case "3":
       $output= $this->survey($from_number,$message);
    break;
	default:
       		 $output=$this->getSmsSettingsTable()->getSetMessage('menu_registered_user')->value;
      		break;
	 }
						}else {
    	$output=$this->getSmsSettingsTable()->getSetMessage('menu_unregistered_user')->value;    
    //break; 
	
    }

	 return $output;
    }
    
    public function getnationalID($from_number,$message,$user_id){
    
        $exploded = explode(" ", $message, 3);
       // print_r($exploded);
       // return $exploded; 
	   // exit(); 
       //in case we don't have the second name we through an error and request for it again
       if(empty($exploded[1])){
       	$data=array(
                            'user_id'=>$user_id,
                            'activity'=>4,
                            //'progress'=>2,
                            'message_received'=>$message
                        ); 
  		//create data points
  		//print_r($this->getUserSmsInteractionsTable());
		//exit();
  		$log = $this->getUserSmsInteractionsTable()->createActivity($data);
		// echo $log;
  		 // exit();
       	$output=$this->getSmsSettingsTable()->getSetMessage('request_full_name')->value;
       }else{
        $data=array(
        
		
            'first_name'=>(!empty($exploded[0])) ? $exploded[0] : null,
            'last_name'=>(!empty($exploded[1])) ? $exploded[1] : null,
            'other_name'=>(!empty($exploded[2])) ? $exploded[2] : null,
            'progress'=>2
            );
        //print_r($data);
        $this->getUserTable()->updateUser($data,$from_number);
		
		$data=array(
                            'user_id'=>$user_id,
                            'activity'=>2,
                            //'progress'=>2,
                            'message_received'=>$message
                        ); 
  		//create data points
  		$log = $this->getUserSmsInteractionsTable()->createActivity($data);
        
        //gets next question after inserting firstname and second name and udatees progress
         $output=$this->getSmsSettingsTable()->getSetMessage('app_national_id')->value;
		
        
	   }
	   return $output;
    }
    public function thankyouMsg($from_number,$message,$user_id){
    	//lets validate national ID to check if it it numeric
    	//$output = is_numeric($message);
		if(is_numeric($message)){
        $data=array(
            'national_id'=>$message,
            'progress'=>0,
            'session'=>0
        );
        $this->getUserTable()->updateUser($data,$from_number);
        //create logs
        $data=array(
                            'user_id'=>$user_id,
                            'activity'=>3,
                            //'progress'=>2,
                            'message_received'=>$message
                        ); 
  		//create data points
  		$log = $this->getUserSmsInteractionsTable()->createActivity($data);

       $test_to_take =  $user_details = $this->getUserTable()->checkUserDetails($from_number)->test_to_take;
       
        $output = array();
  
        $message=$this->getSmsSettingsTable()->getSetMessage('app_thank_you_msg')->value;
		array_push($output,$message);
    if(strlen($test_to_take)>1){
        //$thankyouMsg = $this->getSmsSettingsTable()->getSetMessage('app_thank_you_msg')->value;
        //$output = array();

        $message = $this->test($from_number,$test_to_take);
        //$output = $output." ".$message;
        if(is_array($message)){
        foreach ($message as $key => $value) {
           array_push($output,$value); 
        }
		}else{
			array_push($output,$message); 
		}
        //$output = array($output,$message);
      }

		}
		else{
			//create log
			$data=array(
                            'user_id'=>$user_id,
                            'activity'=>5,
                            //'progress'=>2,
                            'message_received'=>$message
                        ); 
  		//create data points
  		$log = $this->getUserSmsInteractionsTable()->createActivity($data);
		//end of log creation
		$output = $this->getSmsSettingsTable()->getSetMessage('send_national_id')->value;
			
		}
		return $output;
    }
  
    


    public function addAction()
    {
    }

    public function editAction()
    {
    }

    public function deleteAction()
    {
    }


     public function getSmsTable()
    {
        if (!$this->SmsTable) {
            $sm = $this->getServiceLocator();
            $this->SmsTable = $sm->get('Sms\Model\SmsTable');
        }
        return $this->SmsTable;
    }
    public function getRegistrationTable()
    {
        if (!$this->RegistrationTable) {
            $sm = $this->getServiceLocator();
            $this->RegistrationTable = $sm->get('Sms\Model\RegistrationTable');
        }
        return $this->RegistrationTable;
    }
    
    public function getProgressTable()
    {
        if (!$this->ProgressTable) {
            $sm = $this->getServiceLocator();
            $this->ProgressTable = $sm->get('Sms\Model\ProgressTable');
        }
        return $this->ProgressTable;
    }
	
	public function getSmsgatewayTable()
    {
        if (!$this->SmsgatewayTable) {
            $sm = $this->getServiceLocator();
            $this->SmsgatewayTable = $sm->get('Sms\Model\SmsgatewayTable');
        }
        return $this->SmsgatewayTable;
    }
	
	public function getSmsSwitchTable()
    {
        if (!$this->SmsSwitchTable) {
            $sm = $this->getServiceLocator();
            $this->SmsSwitchTable = $sm->get('Sms\Model\SmsSwitchTable');
        }
        return $this->SmsSwitchTable;
    }
	//getUserTable
	public function getUserTable()
    {
        if (!$this->UserTable) {
            $sm = $this->getServiceLocator();
            $this->UserTable = $sm->get('Sms\Model\UserTable');
        }
        return $this->UserTable;
    }
	//get certificates table
	public function getCertificatesTable()
    {
        if (!$this->CertificatesTable) {
            $sm = $this->getServiceLocator();
            $this->CertificatesTable = $sm->get('Sms\Model\CertificatesTable');
        }
        return $this->CertificatesTable;
    }
	//Get course table
	public function getCourseTable()
    {
        if (!$this->CourseTable) {
            $sm = $this->getServiceLocator();
            $this->CourseTable = $sm->get('Sms\Model\CourseTable');
        }
        return $this->CourseTable;
    }
	//getUserCertificatesTable
	
	public function getUserCertificatesTable()
    {
        if (!$this->UserCertificatesTable) {
            $sm = $this->getServiceLocator();
            $this->UserCertificatesTable = $sm->get('Sms\Model\UserCertificatesTable');
        }
        return $this->UserCertificatesTable;
    }
	
	public function getSmsSettingsTable()
    {
        if (!$this->SmsSettingsTable) {
            $sm = $this->getServiceLocator();
            $this->SmsSettingsTable = $sm->get('Sms\Model\SmsSettingsTable');
        }
        return $this->SmsSettingsTable;
    }
		//quiztable
    public function getQuizTable()
    {
        if (!$this->QuizTable) {
            $sm = $this->getServiceLocator();
            $this->QuizTable = $sm->get('Sms\Model\QuizTable');
        }
        return $this->QuizTable;
    }
	
	public function getSmsToBeSentTable()
    {
        if (!$this->SmsToBeSentTable) {
            $sm = $this->getServiceLocator();
            $this->SmsToBeSentTable = $sm->get('Sms\Model\SmsToBeSentTable');
        }
        return $this->SmsToBeSentTable;
    }
	
    public function getQuestionTable()
    {
        if (!$this->QuestionTable) {
            $sm = $this->getServiceLocator();
            $this->QuestionTable = $sm->get('Sms\Model\QuestionTable');
        }
        return $this->QuestionTable;
    }
    //choices table
    public function getChoicesTable()
    {
        if (!$this->ChoicesTable) {
            $sm = $this->getServiceLocator();
            $this->ChoicesTable = $sm->get('Sms\Model\ChoicesTable');
        }
        return $this->ChoicesTable;
    }

    public function getQuestionRandTable()
    {
        if (!$this->QuestionRandTable) {
            $sm = $this->getServiceLocator();
            $this->QuestionRandTable = $sm->get('Sms\Model\QuestionRandTable');
        }
        return $this->QuestionRandTable;
    }
    public function getQuestionResponsesTable()
    {
        if (!$this->QuestionResponsesTable) {
            $sm = $this->getServiceLocator();
            $this->QuestionResponsesTable = $sm->get('Sms\Model\QuestionResponsesTable');
        }
        return $this->QuestionResponsesTable;
    }
	
	public function getUserSmsInteractionsTable()
    {
        if (!$this->UserSmsInteractionsTable) {
            $sm = $this->getServiceLocator();
            $this->UserSmsInteractionsTable = $sm->get('Sms\Model\UserSmsInteractionsTable');
        }
        return $this->UserSmsInteractionsTable;
    }
	
	public function getUserAssignmentTable()
    {
        if (!$this->UserAssignmentTable) {
            $sm = $this->getServiceLocator();
            $this->UserAssignmentTable = $sm->get('Sms\Model\UserAssignmentTable');
        }
        return $this->UserAssignmentTable;
    }
	
	public function getInvitationTable()
    {
        if (!$this->InvitationTable) {
            $sm = $this->getServiceLocator();
            $this->InvitationTable = $sm->get('Sms\Model\InvitationTable');
        }
        return $this->InvitationTable;
    }
	
	public function getClassTable()
    {
        if (!$this->ClassTable) {
            $sm = $this->getServiceLocator();
            $this->ClassTable = $sm->get('Sms\Model\ClassTable');
        }
        return $this->ClassTable;
    }
	public function getPaymentsTable(){
           if (!$this->paymentsTable) {
            $sm = $this->getServiceLocator();
            $this->paymentsTable = $sm->get('Payments\Model\PaymentsTable');
        }
        return $this->paymentsTable;
    }
	
	
}