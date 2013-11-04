<?php
namespace Sms\Model;

class ClassTableData
{
    public $class_id;
	public $course_id;
	public $test_id;
	public $class_title;
	public $class_description;
	public $class_content;
	public $class_rating;
	
 //    public $current_session;
 //    public $progress;
	

	public function exchangeArray($data){
			$this->class_id = (!empty($data['class_id'])) ? $data['class_id'] : null;
			$this->course_id = (!empty($data['course_id'])) ? $data['course_id'] : null;
			$this->test_id = (!empty($data['test_id'])) ? $data['test_id'] : null;
			
			$this->class_title = (!empty($data['class_title'])) ? $data['class_title'] : null;
			$this->class_description = (!empty($data['class_description'])) ? $data['class_description'] : null;
			$this->class_content = (!empty($data['class_content'])) ? $data['class_content'] : null;
			$this->class_rating = (!empty($data['class_rating'])) ? $data['class_rating'] : null;
			
                        
    }
}