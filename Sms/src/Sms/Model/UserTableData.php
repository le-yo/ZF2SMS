<?php
namespace Sms\Model;

class UserTableData
{
    public $id;
	public $from_number;
	public $location;
	public $email;
	public $first_name;
	public $last_name;
	public $national_id;
    public $current_session;
    public $progress;
    public $test_to_take;

	

	public function exchangeArray($data){
			$this->id = (!empty($data['user_id'])) ? $data['user_id'] : null;
			$this->national_id = (!empty($data['national_id'])) ? $data['national_id'] : null;
			$this->from_number = (!empty($data['phone_number'])) ? $data['phone_number'] : null;
			$this->email = (!empty($data['email'])) ? $data['email'] : null;
			$this->first_name=(!empty($data['first_name'])) ? $data['first_name'] : null;
			$this->last_name=(!empty($data['last_name'])) ? $data['last_name'] : null;
			$this->national_id=(!empty($data['national_id'])) ? $data['national_id'] : null;
			$this->session=(!empty($data['session'])) ? $data['session'] : null;
            $this->progress=(!empty($data['progress'])) ? $data['progress'] : null;
            $this->test_to_take=(!empty($data['test_to_take'])) ? $data['test_to_take'] : null;

                        
    }
}