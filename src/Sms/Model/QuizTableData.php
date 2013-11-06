<?php
namespace Sms\Model;

class QuizTableData
{
    public $id;
	public $quiz_name;
	public $intro_text;
	public $class_id;
	public $institution_id;
	public $airtime_reward;
	public $no_of_people;
 	public $quiz_deadline;
	public $airtime_reward_status;
	public $published;
	//public $lang;
 //    public $progress;
	

	public function exchangeArray($data){
			$this->id = (!empty($data['id'])) ? $data['id'] : null;
			$this->quiz_name = (!empty($data['quiz_name'])) ? $data['quiz_name'] : null;
			$this->intro_text = (!empty($data['intro_text'])) ? $data['intro_text'] : null;
			$this->class_id = (!empty($data['class_id'])) ? $data['class_id'] : null;
			$this->institution_id = (!empty($data['institution_id'])) ? $data['institution_id'] : null;
			$this->airtime_reward = (!empty($data['airtime_reward'])) ? $data['airtime_reward'] : null;
			$this->no_of_people = (!empty($data['no_of_people'])) ? $data['no_of_people'] : null;
			$this->quiz_deadline = (!empty($data['quiz_deadline'])) ? $data['quiz_deadline'] : null;
			$this->airtime_reward_status = (!empty($data['airtime_reward_status'])) ? $data['airtime_reward_status'] : null;
			$this->published=(!empty($data['published'])) ? $data['published'] : null;
			// $this->last_name=(!empty($data['last_name'])) ? $data['last_name'] : null;
			// $this->national_id=(!empty($data['national_id'])) ? $data['national_id'] : null;
			// $this->session=(!empty($data['session'])) ? $data['session'] : null;
   //          $this->progress=(!empty($data['progress'])) ? $data['progress'] : null;
                        
    }
}