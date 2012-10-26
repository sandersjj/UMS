<?php

return array(
    'controllers' => array(
        'invokables' => array(
            'Ums\Controller\Registration' => 'Ums\Controller\RegistrationController',
            'Ums\Controller\Login' => 'Ums\Controller\LoginController',
            'Ums\Controller\Profile' => 'Ums\Controller\ProfileController',
            'Ums\Controller\Memo' => 'Ums\Controller\MemoController',
        ),
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'UmsUserAuthentication' => 'Ums\Controller\Plugin\Authentication',
        ),
    ),
    'router' => array(
        'routes' => array(
            'register' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/register',
                    'defaults' => array(
                        'controller' => 'Ums\Controller\Registration',
                        'action' => 'register',
                    ),
                ),
            ),
            'login' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/login',
                    'defaults' => array(
                        'controller' => 'Ums\Controller\Login',
                        'action' => 'login',
                    )
                ),
            ),
            'logout' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/logout',
                    'defaults' => array(
                        'controller' => 'Ums\Controller\Login',
                        'action' => 'logout',
                    )
                ),
            ),
            'recover' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/recover',
                    'defaults' => array(
                        'controller' => 'Ums\Controller\Login',
                        'action' => 'recover',
                    )
                ),
            ),
            'verify' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/verify/email/:email/activation_key/:activation_key',
                    'defaults' => array(
                        'controller' => 'Ums\Controller\Registration',
                        'action' => 'verify',
                    )
                ),
            ),
            'profile' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/profile/view[/:id]',
                    'defaults' => array(
                        'controller' => 'Ums\Controller\Profile',
                        'action' => 'view',
                    )
                ),
            ),
            'users' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/profile/list',
                    'defaults' => array(
                        'controller' => 'Ums\Controller\Profile',
                        'action' => 'list',
                    )
                ),
            ),
            'question' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/question[/:id][/:email][/:question]',
                    'defaults' => array(
                        'controller' => 'Ums\Controller\Login',
                        'action' => 'question',
                    )
                ),
            ),
            'memo' => array(
                'type' => 'Segment',
                'options' => array(
                    'route' => '/note/add[/:id]',
                    'defaults' => array(
                        'controller' => 'Ums\Controller\Memo',
                        'action' => 'add'
                    ),
                ),
            ),
        ),
    ),
    'view_manager' => array(
        'template_path_stack' => array(
            'ums' => __DIR__ . '/../view',
        ),
    ),
    'doctrine' => array(
        'driver' => array(
            'orm_default' => array(
                'drivers' => array(
                    'Ums' => 'ums_driver'
                )
            ),
            'ums_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array('Ums\Entity')
            ),
        ),
        'authentication' => array(
            'orm_default' => array(
                'object_manager' => 'Doctrine\ORM\Entity\Manager',
                'identity_class' => 'Ums\Entity\User',
                'identity_property' => 'email',
                'credential_property' => 'password',
                'credential_callable' => function($user, $passwordGiven) {
                    $params = array($user, $passwordGiven, 'sha1');
                    $result = call_user_func_array('Ums\EntityRepository\User::hashPassword', $params);
                    return $result;
                },
            ),
        ),
    ),
);