<?php

namespace Ums\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Mvc\Controller\Plugin\FlashMessenger as Messenger;


/**
 * This viewhelper invokes the flashmessenger
 */
class FlashMessenger extends AbstractHelper{
    
    protected $flashMessenger;
    
    public function __construct(Messenger $flashMessenger) {
        $this->flashMessenger = $flashMessenger;
        
    }
    
    public function __invoke() {
        return $this->flashMessenger;
    }
}

