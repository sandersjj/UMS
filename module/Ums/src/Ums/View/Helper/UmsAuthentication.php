<?php
namespace Ums\View\Helper;

use Zend\View\Helper\AbstractHelper;
use Zend\Authentication\AuthenticationService;
use Ums\EntityRepository\user as User;

class UmsAuthentication extends AbstractHelper{
    
    /**
     *
     * @var AuthenticationService 
     */
    protected $authService;
    
    
    /**
     * 
     * @param \Ums\View\Helper\User $user
     * @return object. \Ums\View\Helper\User $user
     */
    public function __invoke(User $user = null) {
        if($user === null){
            if($this->getAuthService()->hasIdentity())
                return $this->getAuthService()->getIdentity ();
                
            else{
                return false;
            }
        }
        
    }
    
    /**
     * 
     * getters and setters
     */
    public function getAuthService(){
        return $this->authService;
    }
    
    public function setAuthService(AuthenticationService $authService){
        $this->authService = $authService;
        return $this;
    }
    
    
}