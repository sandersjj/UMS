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
        $model->setActivation_hash(md5(date(d) . rand()));

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

    /**
     * Function checks wether the password key is valid
     * @param type $email
     * @param type $key
     * @return boolean
     */
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
     * function retrieves the user by the email addrss
     * @param type $email
     * @return type
     */
    public function getUserByEmail($email){
        return $this->findOneBy(array('email' =>$email));
    }
    
    /**
     * This function rests the user password
     * @param Ums\Entity\User $user
     * @return boolean
     */
    public function resetUserPassword($user){
        
        $em = $this->getEntityManager();
        $password = $this->createRandomPassword();
        $user->setPassword(User::sha1 . $password);
        $em->merge($user);
        $em->flush();
         
        return $password;
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
     * 
     * @param type $data add a memo to a user
     */
    public function addMemo($data){
        $em = $this->getEntityManager();
        
        $user = $this->findOneBy(array('id' => $data->user));
        
        $memo = new \Ums\Entity\Memo();
        $memo->setMemo($data->memo);
        
        $user->addMemo($memo);
        $em->persist($user);
        $em->flush();
        
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
    
    /**
     * This function creates a random password
     * @return string
     */
    private function createRandomPassword() { 

    $chars = "abcdefghijkmnopqrstuvwxyz023456789"; 
    srand((double)microtime()*1000000); 
    $i = 0; 
    $pass = '' ; 

    while ($i <= 7) { 
        $num = rand() % 33; 
        $tmp = substr($chars, $num, 1); 
        $pass = $pass . $tmp; 
        $i++; 
    } 

    return $pass; 

} 

}
