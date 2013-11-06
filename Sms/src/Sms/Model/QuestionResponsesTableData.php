<?php
namespace Sms\Model;

class QuestionResponsesTableData
{
	public $id;
    public $user_id; 
    public $test_id;
    public $response_id;	
	public $question_id;
	public $attempt;
	public $answer_id;
	// public $national_id;
 //    public $current_session;
 //    public $progress;
	

	public function exchangeArray($data){
		    $this->id = (!empty($data['id'])) ? $data['id'] : null;
			$this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
			$this->test_id = (!empty($data['test_id'])) ? $data['test_id'] : null;
			$this->response_id = (!empty($data['response_id'])) ? $data['response_id'] : null;
			$this->question_id = (!empty($data['question_id'])) ? $data['question_id'] : null;
			$this->attempt=(!empty($data['status'])) ? $data['status'] : null;
			$this->answer_id=(!empty($data['answer_id'])) ? $data['answer_id'] : null;
			// $this->national_id=(!empty($data['national_id'])) ? $data['national_id'] : null;
			// $this->session=(!empty($data['session'])) ? $data['session'] : null;
   //          $this->progress=(!empty($data['progress'])) ? $data['progress'] : null;
                        
    }
}