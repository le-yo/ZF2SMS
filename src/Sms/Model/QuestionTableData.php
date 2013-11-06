<?php
namespace Sms\Model;

class QuestionTableData
{
    public $id;
	public $question_text;
	public $points;
	public $quiz_id;
	//public $;
	// public $first_name;
	// public $last_name;
	// public $national_id;
 //    public $current_session;
 //    public $progress;
	

	public function exchangeArray($data){
			$this->id = (!empty($data['id'])) ? $data['id'] : null;
			$this->question_text = (!empty($data['question_text'])) ? $data['question_text'] : null;
			$this->points = (!empty($data['point'])) ? $data['point'] : null;
			$this->quiz_id = (!empty($data['quiz_id'])) ? $data['quiz_id'] : null;
			// $this->first_name=(!empty($data['first_name'])) ? $data['first_name'] : null;
			// $this->last_name=(!empty($data['last_name'])) ? $data['last_name'] : null;
			// $this->national_id=(!empty($data['national_id'])) ? $data['national_id'] : null;
			// $this->session=(!empty($data['session'])) ? $data['session'] : null;
   //          $this->progress=(!empty($data['progress'])) ? $data['progress'] : null;
                        
    }
}