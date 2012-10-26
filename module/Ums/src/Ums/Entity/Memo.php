<?php

namespace Ums\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 *
 * @ORM\Entity(repositoryClass="Ums\EntityRepository\User")
 * @ORM\Table(name="memo")
 * @ORM\HasLifecycleCallbacks()
 */

class Memo {

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column 
     */
    protected $memo;
    
     /**
     * @ORM\ManyToOne(targetEntity="User")
     * #ORM\JoinColumn(name="user_is", referencedColumnName="id")
     */
    protected $users;
    
   
     
    
    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getMemo() {
        return $this->memo;
    }

    public function setMemo($memo) {
        $this->memo = $memo;
    }
    
    public function addMemo(User $user){
        if ($this->users->contains($user)) {
            return;
        }

        $this->users->add($user);
        $user->addUserMemo($this);
    }



}