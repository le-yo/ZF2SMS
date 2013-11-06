<?php
namespace Sms\Model;

class ChoicesTableData
{
    public $id;
	public $answer_text;
	public $correct_answer;
	public $is_correct_answer;
	//public $quiz_id;
	//public $;
	// public $first_name;
	// public $last_name;
	// public $national_id;
 //    public $current_session;
 //    public $progress;
	

	public function exchangeArray($data){
			$this->id = (!empty($data['id'])) ? $data['id'] : null;
			$this->answer_text = (!empty($data['answer_text'])) ? $data['answer_text'] : null;
			$this->correct_answer = (!empty($data['correct_answer'])) ? $data['correct_answer'] : null;
			$this->is_correct_answer = (!empty($data['is_correct_answer'])) ? $data['is_correct_answer'] : null;
			// $this->first_name=(!empty($data['first_name'])) ? $data['first_name'] : null;
			// $this->last_name=(!empty($data['last_name'])) ? $data['last_name'] : null;
			// $this->national_id=(!empty($data['national_id'])) ? $data['national_id'] : null;
			// $this->session=(!empty($data['session'])) ? $data['session'] : null;
   //          $this->progress=(!empty($data['progress'])) ? $data['progress'] : null;
                        
    }
}