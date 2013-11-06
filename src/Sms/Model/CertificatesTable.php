<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;

class CertificatesTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


   public function getInstitutionDetails($message){
   	
		$rowset = $this->tableGateway->select(array('certificate_code' => $message));
		$row = $rowset->current();
		//print_r($row);
		if(!$row){
			$row = array(
			'institution_id' => 'no institution',
			'Name' => 'no name'
			);
			
			$row = (object) $row;
			//$this->action_id = 7;
			
		}
		return $row;
		
	}
   
      public function checkCertificateAvailability($courseID){
   	
		$rowset = $this->tableGateway->select(array('course_id' => $courseID));
		$row = $rowset->current();
		//print_r($row);
		if(!$row){
			$row = array(
			'course_id' => 0,
			//'Name' => 'no name'
			);
			
			$row = (object) $row;
			//$this->action_id = 7;
			
		}
		return $row;
		
	}
   

   
}