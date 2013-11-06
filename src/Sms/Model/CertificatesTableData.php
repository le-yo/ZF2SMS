<?php
namespace Sms\Model;

class CertificatesTableData
{
	public $certificate_id;
	public $course_id;
	public $certificate_name;
	public $certificate_code;
    public $institution_id;
    public $value;
    
    //public $from_number;

    public function exchangeArray($data)
    {
    	$this->certificate_id     = (!empty($data['certificate_id'])) ? $data['certificate_id'] : null;
		$this->course_id  = (!empty($data['course_id'])) ? $data['course_id'] : null;
		$this->certificate_name = (!empty($data['certificate_name'])) ? $data['certificate_name'] : null;
		$this->certificate_code = (!empty($data['certificate_code'])) ? $data['certificate_code'] : null;
        $this->institution_id     = (!empty($data['institution_id'])) ? $data['institution_id'] : null;
        $this->value     = (!empty($data['value'])) ? $data['value'] : null;
        
        //$this->from_number  = (!empty($data['from_number'])) ? $data['from_number'] : null;
    }
}