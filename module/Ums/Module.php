<?php

namespace Ums;

use Zend\Mvc\MvcEvent;

class Module {

    public function onBootstrap(MvcEvent $e) {
        $application = $e->getApplication();
        $serviceManager = $application->getServiceManager();
        $application->getServiceManager()->get('HttpRouter')->setBaseUrl('http://ums/');
        $controllerLoader = $serviceManager->get('ControllerLoader');

        // Add initializer to Controller Service Manager that check if controllers needs entity manager injection
        $controllerLoader->addInitializer(function ($instance) use ($serviceManager) {
                    if (method_exists($instance, 'setEntityManager')) {
                        $instance->setEntityManager($serviceManager->get('doctrine.entitymanager.orm_default'));
                    }
                });
    }

    public function getAutoloaderConfig() {
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

    /**
     * 
     * @return array config array
     */
    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    /**
     * 
     * @return Ums\View\Helper\FlashMessenger
     */
    public function getViewHelperConfig() {
        return array(
            'factories' => array(
                'flashMessenger' => function($sm) {
                    $locator = $sm->getServiceLocator()
                            ->get('ControllerPluginManager')
                            ->get('flashMessenger');
                    $flashMessenger = new \Ums\View\Helper\FlashMessenger($locator);
                    return $flashMessenger;
                },
                'umsAuthentication' => function($sm) {
                    $locator = $sm->getServiceLocator();
                    $viewHelper = new View\Helper\UmsAuthentication();
                    $viewHelper->setAuthService($locator->get('Zend\Authentication\AuthenticationService'));
                    return $viewHelper;
                }
            ),
        );
    }

    public function getServiceConfig() {
        return array(
            'factories' => array(
                'Zend\Authentication\AuthenticationService' => function($serviceManager) {
                    // If you are using DoctrineORMModule:
                    return $serviceManager->get('doctrine.authenticationservice.orm_default');
                }
            ),
        );
    }

}