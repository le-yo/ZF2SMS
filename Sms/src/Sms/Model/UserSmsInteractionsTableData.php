<?php
namespace Sms\Model;

class UserSmsInteractionsTableData
{
    public $id;
	public $user_id;
	public $activity;
	public $quiz_id;
	public $progress;
	public $timestamp;
	public $score;
	public $error;
	//public $error_details;
	public $survey_id;
	public $question_id;
	public $message_received;
	public $phone_number;
	
	// public $national_id;
//     
    // public $progress;
    // public $test_to_take;

	

	public function exchangeArray($data){
			$this->id = (!empty($data['user_id'])) ? $data['user_id'] : null;
			$this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
			$this->activity = (!empty($data['activity'])) ? $data['activity'] : null;
			$this->quiz_id = (!empty($data['quiz_id'])) ? $data['quiz_id'] : null;
			$this->score = $data['score'];
			$this->error = (!empty($data['error'])) ? $data['error'] : null;
			$this->survey_id = (!empty($data['survey_id'])) ? $data['survey_id'] : null;
			$this->question_id = (!empty($data['question_id'])) ? $data['question_id'] : null;
			$this->message_received = (!empty($data['message_received'])) ? $data['message_received'] : null;
			$this->phone_number = (!empty($data['phone_number'])) ? $data['phone_number'] : null;
			// $this->first_name=(!empty($data['first_name'])) ? $data['first_name'] : null;
			// $this->last_name=(!empty($data['last_name'])) ? $data['last_name'] : null;
			// $this->national_id=(!empty($data['national_id'])) ? $data['national_id'] : null;
			// $this->session=(!empty($data['session'])) ? $data['session'] : null;
            $this->progress=(!empty($data['progress'])) ? $data['progress'] : null;
            $this->timestamp=(!empty($data['timestamp'])) ? $data['timestamp'] : null;

                        
    }
}