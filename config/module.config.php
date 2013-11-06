<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Sms\Controller\SmsRestful' => 'Sms\Controller\SmsRestfulController',
            'Sms\Controller\SmsClient' => 'Sms\Controller\SmsClientController',
        ),
    ),
    'router' => array(
        'routes' => array(
            'Sms' => array(
                'type'    => 'Literal',
                'options' => array(
                    // Change this to something specific to your module
                    'route'    => '/Sms',
                    'defaults' => array(
                        // Change this value to reflect the namespace in which
                        // the controllers for your module are found
                        '__NAMESPACE__' => 'Sms\Controller',
                        'controller'    => 'Sms\Controller\SmsRestful',
                        'action'     => 'create'
                    ),
                ),
                 
                'may_terminate' => true,
                'child_routes' => array(
                    'client' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/client[/:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Sms\Controller\SmsClient',
                                'action'     => 'index'
                            ),
                        ),
                        
                    ),
                    'SmsRestful' => array(
                        'type'    => 'Segment',
                        'options' => array(
                            'route'    => '/SmsRestful[/:action]',
                            'constraints' => array(
                                'controller' => '[a-zA-Z][a-zA-Z0-9_-]*',
                            ),
                            'defaults' => array(
                                'controller' => 'Sms\Controller\SmsRestful',
                                'action'     => 'create',
                            ),
                        ),
                        
                    ),
                    
					
                ),
            ),
        ),
    ),
);