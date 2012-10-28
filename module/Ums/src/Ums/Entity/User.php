<?php

namespace Ums\Entity;

use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\ArrayCollection;

/**
 *
 * @ORM\Entity(repositoryClass="Ums\EntityRepository\User")
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 */
class User {

    /**
     * @ORM\id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     *
     * @ORM\Column 
     */
    protected $firstname;

    /**
     *
     * @ORM\Column 
     */
    protected $surname;

    /**
     *
     * @ORM\Column(type="string", unique=true)
     */
    protected $email;

    /**
     *
     * @ORM\Column 
     */
    protected $password;

    /**
     *
     * @ORM\Column 
     */
    protected $question;

    /**
     *
     * @ORM\Column 
     */
    protected $answer;

    /**
     * 
     *  @ORM\OneToMany(targetEntity="Memo", mappedBy="user", cascade={"persist"})
     */
    protected $memos;

    /**
     *
     * @ORM\Column(type="integer", length=1)  
     */
    protected $blocked = 0;

    /**
     *
     * @ORM\Column(type="integer", length=1)  
     */
    protected $activated = 0;

    /**
     *
     * @ORM\Column(nullable=true)  
     */
    protected $activation_hash = null;

    /**
     *
     * @ORM\Column(type="integer", length=1)  
     */
    protected $is_admin = 0;

    public function __construct() {
        $this->memos = new ArrayCollection();
    }

    public function getId() {
        return $this->id;
    }

    public function setId($id) {
        $this->id = $id;
    }

    public function getFirstname() {
        return $this->firstname;
    }

    public function setFirstname($firstname) {
        $this->firstname = $firstname;
    }

    public function getSurname() {
        return $this->surname;
    }

    public function setSurname($surname) {
        $this->surname = $surname;
    }

    public function getEmail() {
        return $this->email;
    }

    public function setEmail($email) {
        $this->email = $email;
    }

    public function getPassword() {
        return $this->password;
    }

    public function setPassword($password) {
        $this->password = sha1($password);
    }

    public function getQuestion() {
        return $this->question;
    }

    public function setQuestion($question) {
        $this->question = $question;
    }

    public function getAnswer() {
        return $this->answer;
    }

    public function setAnswer($answer) {
        $this->answer = $answer;
    }

    public function getBlocked() {
        return $this->blocked;
    }

    public function setBlocked($block) {
        $this->block = $block;
    }

    public function getActivation_hash() {
        return $this->activation_hash;
    }

    public function setActivation_hash($activation_hash) {
        $this->activation_hash = $activation_hash;
    }

    public function getActivated() {
        return $this->activated;
    }

    public function setActivated($activated) {
        $this->activated = $activated;
    }

    public function getIs_admin() {
        return $this->is_admin;
    }

    public function setIs_admin($is_admin) {
        $this->is_admin = $is_admin;
    }

    public function getMemo() {
        return $this->memo;
    }

    public function addMemo($memo) {
        if (!$this->memos->contains($memo)) {
            $this->memos->add($memo);
            $memo->setUser($this);
        }
    }
    
    public function getMemos(){
        return $this->memos->getValues();
    }

}