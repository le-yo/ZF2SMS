<?php
namespace Sms\Model;

use Zend\Db\TableGateway\TableGateway;
use Zend\Db\Sql\Select;
use Zend\Db\ResultSet\ResultSet;

class ClassTable
{
    protected $tableGateway;

    public function __construct(TableGateway $tableGateway)
    {
        $this->tableGateway = $tableGateway;
    }


 public function getCourseID($class_id) { 
  //$testID
  //break;
   $rowset = $this->tableGateway->select(array(
      'class_id' => $class_id,
      //'id' => $progress
      ));
    $row = $rowset->current();
            return $row;
}




public function getClasses($courseID){

//$classesIds ='';
    $rowset = $this->tableGateway->select(array(
      //'quiz_id' => $testID,
      'course_id' => $courseID
      ));

  $resultSet = new ResultSet;
    $resultSet->initialize($rowset);
    //$i = 'A';
    //$choices = "";
    if(empty($resultSet)){
		$classesIds = 0;
}else{
    foreach ($resultSet as $row) {
        $classesIds[] = $row->class_id;
        //$i++;
    }
	
}
    return $classesIds;
   }
 }