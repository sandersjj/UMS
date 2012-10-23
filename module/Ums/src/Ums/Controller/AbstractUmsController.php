<?php

namespace Ums\Controller;


use Zend\Mvc\Controller\AbstractActionController;
use Doctrine\ORM\EntityManager;

class AbstractUmsController extends AbstractActionController{
    
    
    protected $entityManager;
    
    public function getEntityManager() {
        return $this->entityManager;
    }

    public function setEntityManager(EntityManager $entityManager) {
        $this->entityManager = $entityManager;
    }
}