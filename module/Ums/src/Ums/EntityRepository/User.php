<?php

namespace Ums\EntityRepository;

use \Doctrine\ORM\EntityRepository as EntityRepository;

class User extends EntityRepository {

    const sha1 = '!*$#&@^j#kV';
    const RESULT_SUCCESS = 1;

    /**
     * 
     * @param array $data
     * @return boolean
     */
    public function createFromArray(Array $data) {

        $em = $this->getEntityManager();
        $model = new \Ums\Entity\User();
        $model->setFirstname($data['firstname']);
        $model->setSurname($data['firstname']);
        $model->setEmail($data['email']);
        $model->setPassword(User::sha1 . $data['password']);
        $model->setQuestion($data['question']);
        $model->setAnswer($data['answer']);
        $model->setActivation_hash(md5(date(D) . rand()));

        $em->persist($model);
        $em->flush();


        return $model;
    }
    
    /**
     * Returns a user object by id 
     * @param type $id
     * @return Object
     */
    public function getUserById($id){
        return $this->findOneBy(array(
            'id' => $id
        ));
    }

        
    public function checkVerification($email, $key) {


        $result = $this->findOneBy(array(
            'email' => $email,
            'activation_hash' => $key,
            'activated' => 0,
                ));
        if ($result !== null) {
            $this->activateAccount($result);
            return true;
        }
    }
    
    /**
     * This function returns all user objects. 
     * @return type
     */
    public function getAllUsers(){
        return $this->findAll();
    }
    

    /**
     * This function sets the account to active. This is required in order to 
     * be able to login.
     * @param type $model
     * @return boolean
     */
    private function activateAccount($model) {
        $em = $this->getEntityManager();
        $model->setActivated(1);

        $em->merge($model);
        $em->flush();
        return true;
    }

    
    
    
    
    /**
     * This function checkes the given password against the password in the db
     * according to the password hash
     * @param type $user
     * @param type $givenPassword
     * @return boolean
     */
    static function hashPassword($user, $givenPassword) {

        $password = sha1(User::sha1 . $givenPassword);

        if ($password == $user->getPassword()
                && $user->getActivated() == 1
                && $user->getBlocked() == 0) {
            return true;
        }

        return false;
    }

}
