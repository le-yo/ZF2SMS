<?php 
namespace Sms\Model;

class User
{
	public $id;
	public $from_number;
	public $location;
	public $email;
	public $first_name;
	public $last_name;
	public $national_id;
	

	public function exchangeArray($data){
			$this->id = (!empty($data['id'])) ? $data['id'] : null;
			$this->national_id = (!empty($data['national_id'])) ? $data['national_id'] : null;
			$this->from_number = (!empty($data['phone_number'])) ? $data['phone_number'] : null;
			$this->email = (!empty($data['email'])) ? $data['email'] : null;
			$this->first_name=(!empty($data['first_name'])) ? $data['first_name'] : null;
			$this->last_name=(!empty($data['last_name'])) ? $data['last_name'] : null;
			$this->last_name=(!empty($data['location'])) ? $data['location'] : null;
	}			

	}