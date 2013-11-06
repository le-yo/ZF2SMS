<?php
namespace Sms\Model;

class SmsToBeSentTableData
{
    public $id;
	public $message;
	public $to;
	public $sender_id;
	public $status;
	//public $course_id;
	//public $institution_id;
	//public $status;
 //    public $current_session;
 //    public $progress;
	

	public function exchangeArray($data){
			$this->id = (!empty($data['id'])) ? $data['id'] : null;
			$this->message = (!empty($data['message'])) ? $data['message'] : null;
			$this->status = (!empty($data['status'])) ? $data['status'] : null;
			$this->to = (!empty($data['to'])) ? $data['to'] : null;
			$this->sender_id = (!empty($data['sender_id'])) ? $data['sender_id'] : null;
			//$this->course_id = (!empty($data['course_id'])) ? $data['course_id'] : null;
			//$this->institution_id = (!empty($data['institution_id'])) ? $data['institution_id'] : null;
			//$this->status = (!empty($data['status'])) ? $data['status'] : null;
			//$this->question_text = (!empty($data['question_text'])) ? $data['question_text'] : null;
			//$this->points = (!empty($data['point'])) ? $data['point'] : null;
			//$this->quiz_id = (!empty($data['quiz_id'])) ? $data['quiz_id'] : null;
			// $this->first_name=(!empty($data['first_name'])) ? $data['first_name'] : null;
			// $this->last_name=(!empty($data['last_name'])) ? $data['last_name'] : null;
			// $this->national_id=(!empty($data['national_id'])) ? $data['national_id'] : null;
			// $this->session=(!empty($data['session'])) ? $data['session'] : null;
   //          $this->progress=(!empty($data['progress'])) ? $data['progress'] : null;
                        
    }
}