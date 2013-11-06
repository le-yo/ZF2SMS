<?php

namespace Sms;

use Sms\Model\Sms;
use Sms\Model\SmsSwitchTable;
use Sms\Model\SmsSwitchData;
use Sms\Model\UserCertificatesTable;
use Sms\Model\UserCertificatesTableData;

use Sms\Model\SmsSettingsTable;
use Sms\Model\SmsSettingsTableData;

use Sms\Model\UserTable;
use Sms\Model\UserTableData;

use Sms\Model\SmsTable;
use Sms\Model\Registration;
use Sms\Model\RegistrationTable;
use Sms\Model\Progress;
use Sms\Model\Smsgateway;
use Sms\Model\SmsgatewayTable;
use Sms\Model\ProgressTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Sms\Model\CertificatesTable;
use Sms\Model\CertificatesTableData;

use Sms\Model\QuizTable;
use Sms\Model\QuizTableData;

use Sms\Model\CourseTable;
use Sms\Model\CourseTableData;

use Sms\Model\QuestionTable;
use Sms\Model\QuestionTableData;

use Sms\Model\ChoicesTable;
use Sms\Model\ChoicesTableData;

use Sms\Model\QuestionRandTable;
use Sms\Model\QuestionRandTableData;

use Sms\Model\QuestionResponsesTable;
use Sms\Model\QuestionResponsesTableData;

use Sms\Model\UserSmsInteractionsTable;
use Sms\Model\UserSmsInteractionsTableData;

use Sms\Model\UserAssignmentTable;
use Sms\Model\UserAssignmentTableData;

use Sms\Model\InvitationTable;
use Sms\Model\InvitationTableData;

use Sms\Model\ClassTable;
use Sms\Model\ClassTableData;

use Sms\Model\SmsToBeSentTable;
use Sms\Model\SmsToBeSentTableData;

use Sms\Library\AfricasTalking;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }
	     public function getServiceConfig()
    {
        return array(
            'factories' => array(
                'Sms\Model\SmsTable' =>  function($sm) {
                    $tableGateway = $sm->get('SmsTableGateway');
                    $table = new SmsTable($tableGateway);
                    return $table;
                },
                'SmsTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Sms());
                    return new TableGateway('starter', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\CertificatesTable' =>  function($sm) {
                    $tableGateway = $sm->get('CertificateTableGateway');
                    $table = new CertificatesTable($tableGateway);
                    return $table;
                },
                'CertificateTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new CertificatesTableData());
                    return new TableGateway('certificate', $dbAdapter, null, $resultSetPrototype);
                },				
				
                'Sms\Model\SmsgatewayTable' =>  function($sm) {
                    $tableGateway = $sm->get('SmsgatewayTable');
                    $table = new SmsgatewayTable($tableGateway);
                    return $table;
                },
                'SmsgatewayTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Smsgateway());
                    return new TableGateway('sms_gateway', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\RegistrationTable' =>  function($sm) {
                    $tableGateway = $sm->get('RegistrationTableGateway');
                    $table = new RegistrationTable($tableGateway);
                    return $table;
                },
                'RegistrationTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Sms());
                    return new TableGateway('appl_message', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\ProgressTable' =>  function($sm) {
                    $tableGateway = $sm->get('ProgressTableGateway');
                    $table = new ProgressTable($tableGateway);
                    return $table;
                },
                'ProgressTableGateway' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new Sms());
                    return new TableGateway('sms_application_progress', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\SmsSwitchTable' =>  function($sm) {
                    $tableGateway = $sm->get('SmsSwitchTable');
                    $table = new SmsSwitchTable($tableGateway);
                    return $table;
                },
                'SmsSwitchTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new SmsSwitchData());
                    return new TableGateway('sms_switch', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\UserTable' =>  function($sm) {
                    $tableGateway = $sm->get('UserTable');
                    $table = new UserTable($tableGateway);
                    return $table;
                },
                'UserTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new UserTableData());
                    return new TableGateway('users', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\SmsSettingsTable' =>  function($sm) {
                    $tableGateway = $sm->get('SmsSettingsTable');
                    $table = new SmsSettingsTable($tableGateway);
                    return $table;
                },
                'SmsSettingsTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new SmsSettingsTableData());
                    return new TableGateway('sms_settings', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\UserCertificatesTable' =>  function($sm) {
                    $tableGateway = $sm->get('UserCertificatesTable');
                    $table = new UserCertificatesTable($tableGateway);
                    return $table;
                },
                'UserCertificatesTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new UserCertificatesTableData());
                    return new TableGateway('user_certificate', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\CourseTable' =>  function($sm) {
                    $tableGateway = $sm->get('CourseTable');
                    $table = new CourseTable($tableGateway);
                    return $table;
                },
                'CourseTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new CourseTableData());
                    return new TableGateway('courses', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\QuizTable' =>  function($sm) {
                    $tableGateway = $sm->get('QuizTable');
                    $table = new QuizTable($tableGateway);
                    return $table;
                },
                'QuizTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new QuizTableData());
                    return new TableGateway('quiz', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\QuestionTable' =>  function($sm) {
                    $tableGateway = $sm->get('QuestionTable');
                    $table = new QuestionTable($tableGateway);
                    return $table;
                },
                'QuestionTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new QuestionTableData());
                    return new TableGateway('questions', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\ChoicesTable' =>  function($sm) {
                    $tableGateway = $sm->get('ChoicesTable');
                    $table = new ChoicesTable($tableGateway);
                    return $table;
                },
                'ChoicesTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ChoicesTableData());
                    return new TableGateway('answers', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\QuestionRandTable' =>  function($sm) {
                    $tableGateway = $sm->get('QuestionRandTable');
                    $table = new QuestionRandTable($tableGateway);
                    return $table;
                },
                'QuestionRandTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new QuestionRandTableData());
                    return new TableGateway('question_randomization', $dbAdapter, null, $resultSetPrototype);
                },

               'Sms\Model\QuestionResponsesTable' =>  function($sm) {
                    $tableGateway = $sm->get('QuestionResponsesTable');
                    $table = new QuestionResponsesTable($tableGateway);
                    return $table;
                },
                'QuestionResponsesTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new QuestionResponsesTableData());
                    return new TableGateway('responses', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\UserSmsInteractionsTable' =>  function($sm) {
                    $tableGateway = $sm->get('UserSmsInteractionsTable');
                    $table = new UserSmsInteractionsTable($tableGateway);
                    return $table;
                },
                'UserSmsInteractionsTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new UserSmsInteractionsTableData());
                    return new TableGateway('user_sms_interactions', $dbAdapter, null, $resultSetPrototype);
                },
                
				'Sms\Model\UserAssignmentTable' =>  function($sm) {
                    $tableGateway = $sm->get('UserAssignmentTable');
                    $table = new UserAssignmentTable($tableGateway);
                    return $table;
                },
                'UserAssignmentTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new UserAssignmentTableData());
                    return new TableGateway('assignment_user', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\InvitationTable' =>  function($sm) {
                    $tableGateway = $sm->get('InvitationTable');
                    $table = new InvitationTable($tableGateway);
                    return $table;
                },
                'InvitationTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new InvitationTableData());
                    return new TableGateway('invitations', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\ClassTable' =>  function($sm) {
                    $tableGateway = $sm->get('ClassTable');
                    $table = new ClassTable($tableGateway);
                    return $table;
                },
                'ClassTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new ClassTableData());
                    return new TableGateway('classes', $dbAdapter, null, $resultSetPrototype);
                },
                'Sms\Model\SmsToBeSentTable' =>  function($sm) {
                    $tableGateway = $sm->get('SmsToBeSentTable');
                    $table = new SmsToBeSentTable($tableGateway);
                    return $table;
                },
                'SmsToBeSentTable' => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new SmsToBeSentTableData());
                    return new TableGateway('sms_to_be_sent', $dbAdapter, null, $resultSetPrototype);
                },            
                

            ),
        );
    }
	
	
}