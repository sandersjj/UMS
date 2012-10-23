<?php

namespace Ums\Controller;

use Ums\Form\Login as LoginForm;

class LoginController extends AbstractUmsController {

    public function loginAction() {
        if ($this->UmsUserAuthentication()->hasIdentity()) {
            $this->flashMessenger()->addMessage('You are already logged in and have been forwarded to the homepage');
            $this->redirect()->toRoute('home');
        }
        $loginForm = new LoginForm();
        $request = $this->getRequest();

        $loginForm->setData($request->getPost());
        if ($request->isPost()) {
            if ($loginForm->isValid()) {
                $data = $loginForm->getData();
                $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
                $adapter = $authService->getAdapter();
                $adapter->setIdentityValue($data['email']);
                $adapter->setCredentialValue($data['password']);
                $authenticationResult = $authService->authenticate($adapter);
                
                
                if ($authenticationResult->getCode() == 1 && $identity = $authenticationResult->getIdentity()) {
                    $authService->getStorage()->write($identity);
                    $this->flashMessenger()->addMessage('You have succesfully logged in and have been forwarded to the homepage');
                    $this->redirect()->toRoute('home');
                }else{
                    $this->flashMessenger()->addMessage('Incorrect login please try again');
                }
            }
        }
        return array('form' => $loginForm);
    }

    public function logoutAction() {
        if ($this->UmsUserAuthentication()->hasIdentity()) {
            
            $authService = $this->getServiceLocator()->get('Zend\Authentication\AuthenticationService');
            $authService->clearIdentity();
            $this->flashMessenger()->addMessage('Please login to see more...');
            $this->redirect()->toRoute('login');
            

        }
                    
    }

}