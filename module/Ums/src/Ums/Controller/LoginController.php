<?php

namespace Ums\Controller;

use Ums\Form\Login as LoginForm;
use Ums\Form\Email as EmailForm;
use Ums\Form\Answer as AnswerForm;
use Zend\Session\SessionManager as Session;

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


                //if success login
                if ($authenticationResult->getCode() == 1 && $identity = $authenticationResult->getIdentity()) {
                    $authService->getStorage()->write($identity);
                    //remember me functionality
                    if(isset($data['cookie'])){
                        $session = new Session();
                        $session->rememberMe(604800);
                    }
                    $this->flashMessenger()->addMessage('You have succesfully logged in and have been forwarded to the homepage');
                    return $this->redirect()->toRoute('home');
                } else {
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
            return $this->redirect()->toRoute('login');
        }
    }

    public function recoverAction() {

        $request = $this->getRequest();


        if (isset($email)) {
            
        } else {
            $emailForm = new EmailForm();
            if ($request->isPost()) {
                $emailForm->setData($request->getPost());
                if ($emailForm->isValid()) {
                    $em = $this->getEntityManager();
                    $user = $em->getRepository('Ums\Entity\User');
                    $userInfo = $user->getUserByEmail($request->getPost()->email);
                    //if account is resetable redirect
                    if ($userInfo->getActivated() == 1 && $userInfo->getBlocked() == 0) {
                        $this->redirect()->toRoute('question', array(
                            'id' => $userInfo->getId(),
                            'email' => $userInfo->getEmail(),
                            'question' => $userInfo->getQuestion()
                        ));
                    }
                }
            }
            return array('form' => $emailForm);
        }
    }

    /**
     * This function manages the security question. If the question is answered 
     * then a new password will be sent to the user. 
     * @return type
     */
    public function questionAction() {
        $id = $this->params()->fromRoute('id');
        $question = $this->params()->fromRoute('question');
        $email = $this->params()->fromRoute('email');

        $answerForm = new AnswerForm();
        $request = $this->getRequest();

        $em = $this->getEntityManager();
        $repo = $em->getRepository('Ums\Entity\User');



        if ($request->isPost()) {
            $answerForm->setData($request->getPost());
            if ($answerForm->isValid()) {
                $data = $request->getPost();
                $userData = $repo->getUserById(intval($data->user));
                if (trim(strtolower($userData->getAnswer())) == trim(strtolower($data->answer))) {
                    $password = $this->ReccoverPassword($data->user);

                    if (!empty($password)) {

                        $this->flashMessenger()->addMessage('Your new password is ' . $password . ' Please check your mail to login.');
                        return $this->redirect()->toRoute('login');
                        
                    }
                }else{
                    
                     $this->flashMessenger()->addMessage('This was not a good answer. Please contact a system administrator');
                     return $this->redirect()->toRoute('recover');  
                }
            }
        } else if (isset($id) && isset($question) && isset($id)) {
            switch ($question) {
                case 'dog':
                    $theQuestion = "What is the name of your dog";
                    break;
                case 'motherinlaw':
                    $theQuestion = "How old was your mother in law when you got married";
                    break;
                case 'color':
                    $theQuestion = "What is your favorite color";
                    break;
            }
            $answerForm->setData(array('user' => $id));

            return (array(
                'form' => $answerForm,
                'question' => $theQuestion
                    )
                    );
        }
    }

    private function ReccoverPassword($userId) {
        $em = $this->getEntityManager();
        $repo = $em->getRepository('Ums\Entity\User');

        $user = $repo->getUserById($userId);
        return $repo->resetUserPassword($user);
    }

}