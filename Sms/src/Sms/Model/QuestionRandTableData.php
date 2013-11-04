<?php
namespace Sms\Model;

class QuestionRandTableData
{
    public $user_id;
	public $test_id;
	public $order;
	public $status;
	//public $;
	// public $first_name;
	// public $last_name;
	// public $national_id;
 //    public $current_session;
 //    public $progress;
	

	public function exchangeArray($data){
			$this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
			$this->test_id = (!empty($data['test_id'])) ? $data['test_id'] : null;
			$this->order = (!empty($data['order'])) ? $data['order'] : null;
			$this->status = (!empty($data['status'])) ? $data['status'] : null;
			// $this->first_name=(!empty($data['first_name'])) ? $data['first_name'] : null;
			// $this->last_name=(!empty($data['last_name'])) ? $data['last_name'] : null;
			// $this->national_id=(!empty($data['national_id'])) ? $data['national_id'] : null;
			// $this->session=(!empty($data['session'])) ? $data['session'] : null;
   //          $this->progress=(!empty($data['progress'])) ? $data['progress'] : null;
                        
    }
}