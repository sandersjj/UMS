<?php

namespace Ums\Controller;

use Zend\View\Model\ViewModel;

class ProfileController extends AbstractUmsController {

    /**
     * This function returns the profile of the logged in user. 
     * @return \Zend\View\Model\ViewModel
     */
    public function viewAction() {

        $em = $this->getEntityManager();
        $repo = $em->getRepository('Ums\Entity\User');

        $id = $this->params()->fromRoute('id');

        if (!empty($id)) {
            return new ViewModel(array(
                        'profile' => $repo->getUserById($this->params()->fromRoute('id')),
                    ));
        }

        if ($this->UmsUserAuthentication()->hasIdentity() && !isset($id)) {
            $identity = $this->UmsUserAuthentication()->getIdentity();
            return new ViewModel(array(
                        'profile' => $identity,
                    ));
        }
    }

    /**
     * This function will list all the users in the system
     * To be used for the admin. 
     * 
     */
    public function listAction() {

        $em = $this->getEntityManager();
        $repo = $em->getRepository('Ums\Entity\User');


        return new viewModel(array(
                    'users' => $repo->getAllUsers(),
                ));
    }

}