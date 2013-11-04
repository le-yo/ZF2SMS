<?php
namespace Sms\Model;

class UserCertificatesTableData
{
	public $id;
    public $user_id;
	public $certificate_code;
	public $course_id;
	public $status;
	public $amount;
    public $timestamp;
    //public $message_id;
    //public $from_number;

    public function exchangeArray($data)
    {
    	$this->id     = (!empty($data['id'])) ? $data['id'] : null;	
        $this->user_id     = (!empty($data['user_id'])) ? $data['user_id'] : null;
		$this->certificate_code=(!empty($data['certificate_code'])) ? $data['certificate_code'] : null;
        $this->course_id=(!empty($data['course_id'])) ? $data['course_id'] : null;
		$this->status=(!empty($data['status'])) ? $data['status'] : null;
		$this->amount=(!empty($data['amount'])) ? $data['amount'] : null;
        $this->timestamp = (!empty($data['timestamp'])) ? $data['timestamp'] : null;
        //$this->message_id  = (!empty($data['message_id'])) ? $data['message_id'] : null;
        //$this->from_number  = (!empty($data['from_number'])) ? $data['from_number'] : null;
    }
	
}