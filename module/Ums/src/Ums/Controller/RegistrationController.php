<?php

namespace Ums\Controller;

use Zend\Mail\Message;
use Zend\Mail\Transport\Smtp as SmtpTransport;
use Zend\Mail\Transport\SmtpOptions;
use Zend\Mime\Message as MimeMessage;
use Zend\Mime\Part as MimePart;
use Ums\Form\Registration as RegistrationForm;
use Ums\Form\RegistrationFilter as RegistrationFilter;

Class RegistrationController extends AbstractUmsController {

    public function registerAction() {


        $form = new RegistrationForm;
        $form->setInputFilter(new RegistrationFilter());

        $em = $this->getEntityManager();



        /**
         * gedurende ontwikkeling wordt deze tabel steeds opnieuw aangemaakt
         */
//        $classes = array(
//            $em->getClassMetadata('Ums\Entity\User'),
//        );
//
//        $tool = new \Doctrine\ORM\Tools\SchemaTool($em);
//
//        try {
//            $tool->dropSchema($classes);
//        } catch (Exception $e) {
//            print $e->getMessage();
//        }
//        $tool->createSchema($classes);
        /**
         * gedurende ontwikkeling wordt deze tabel steeds opnieuw aangemaakt
         */
        $repo = $em->getRepository('Ums\Entity\User');

        $request = $this->getRequest();
        if ($request->isPost()) {

            $form->setData($request->getPost());
            if ($form->isValid()) {
                if ($model = $repo->createFromArray($form->getData())) {
                    $this->sendConfirmationMail($model);
                    $this->flashMessenger()->addMessage('You have succesfully created an account');
                    $this->redirect()->toRoute('home');
                }
            }
        }
        return array('form' => $form);
    }

    public function verifyAction() {

        $email = $this->params()->fromRoute('email');
        $key = $this->params()->fromRoute('activation_key');

        $em = $this->getEntityManager();
        $repo = $em->getRepository('Ums\Entity\User');
        $result = $repo->checkVerification($email, $key);
        if ($result) {
            $this->flashMessenger()->addMessage('Your account has been activated, you may login');
            $this->redirect()->toRoute('home');
            
        }
   
    }

    private function sendConfirmationMail($model) {
        $message = new Message();
        $message->addFrom('Jigalroecha@gmail.com', 'Ums user system')
                ->addTo($model->getEmail(), $model->getFirstname() . $model->getSurname())
                ->setSubject('New registration by the ums user system');

        $url = $_SERVER["HTTP_HOST"] . '/verify/email/' . $model->getEmail() . '/activation_key/' . $model->getActivation_hash();

        $htmlMarkup = "Beste " . $model->getFirstname() . ",\n";
        $htmlMarkup.= "Welkom bij Ums. Klik op de onderstaande link om je account te activeren. \n";
        $htmlMarkup.= "<a href='" . $url . "'> link</a>";

        $html = new MimePart($htmlMarkup);
        $html->type = "text/html";

        $body = new MimeMessage();
        $body->setParts(array($html));

        $message->setBody($body);
        $message->setEncoding("UTF-8");


        $transport = new SmtpTransport();
        $options = new SmtpOptions(array(
                    'name' => 'gmail',
                    'host' => 'smtp.gmail.com',
                    'port' => 587, // Notice port change for TLS is 587
                    'connection_class' => 'plain',
                    'connection_config' => array(
                        'username' => 'jigalroecha@gmail.com',
                        'password' => 'T0rendruk',
                        'ssl' => 'tls',
                    ),
                ));
        $transport->setOptions($options);
        $transport->send($message);
        return;
    }

}
