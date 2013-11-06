<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;

class CourseTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


   public function getCourseDetails($CourseID){
   		//echo $UserID;
		$rowset = $this->tableGateway->select(array('course_id' => $CourseID));
		$row = $rowset->current();
		//print_r($row);
		if(!$row){
			$row = array('course_name' => 'No Course');
			
			$row = (object) $row;
			//$this->action_id = 7;
			
		}
		return $row;
		
	}

   
}