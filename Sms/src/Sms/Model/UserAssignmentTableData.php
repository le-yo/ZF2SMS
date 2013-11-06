<?php
namespace Sms\Model;

class UserAssignmentTableData
{
	public $id;
    public $assignment_id; 
    public $user_id;
    public $status;	
	public $created_on;
	public $started_at;
	public $completed_at;
	public $score;
 //    public $current_session;
 //    public $progress;
	

	public function exchangeArray($data){
		    $this->id = (!empty($data['id'])) ? $data['id'] : null;
			$this->assignment_id = (!empty($data['assignment_id'])) ? $data['assignment_id'] : null;
			$this->user_id = (!empty($data['user_id'])) ? $data['user_id'] : null;
			$this->status = (!empty($data['status'])) ? $data['status'] : null;
			$this->created_on = (!empty($data['created_on'])) ? $data['created_on'] : null;
			$this->started_at = (!empty($data['started_at'])) ? $data['started_at'] : null;
			$this->completed_at = (!empty($data['completed_at'])) ? $data['completed_at'] : null;
			$this->score = (!empty($data['score'])) ? $data['score'] : null;
			
			// $this->national_id=(!empty($data['national_id'])) ? $data['national_id'] : null;
			// $this->session=(!empty($data['session'])) ? $data['session'] : null;
   //          $this->progress=(!empty($data['progress'])) ? $data['progress'] : null;
                        
    }
}