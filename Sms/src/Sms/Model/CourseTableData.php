<?php
namespace Sms\Model;

class CourseTableData
{
    public $course_id;
	public $course_name;
	public $course_description;
	public $course_short_name;
	public $institution_id;
	//public $course_description;
	//public $last_name;
	//public $national_id;
        //public $current_session;
        //public $progress;
	

	public function exchangeArray($data){
			$this->course_id = (!empty($data['course_id'])) ? $data['course_id'] : null;
			$this->course_name = (!empty($data['course_name'])) ? $data['course_name'] : null;
			$this->course_description = (!empty($data['course_description'])) ? $data['course_description'] : null;
			$this->course_short_name = (!empty($data['course_short_name'])) ? $data['course_short_name'] : null;
			$this->institution_id = (!empty($data['institution_id'])) ? $data['institution_id'] : null;
			//$this->first_name=(!empty($data['first_name'])) ? $data['first_name'] : null;
			//$this->last_name=(!empty($data['last_name'])) ? $data['last_name'] : null;
			//$this->national_id=(!empty($data['national_id'])) ? $data['national_id'] : null;
			//$this->session=(!empty($data['session'])) ? $data['session'] : null;
            //$this->progress=(!empty($data['progress'])) ? $data['progress'] : null;
                        
    }
}