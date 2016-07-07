<?php
namespace Multiple\Library\IOSApi\v1;
use Multiple\Frontend\Models\User;
use Multiple\Frontend\Models\UserIosappHashes;
class LoginMethod extends \Multiple\Library\IOSApi\BaseIOSClass{

    public function runMethod(){
        if(!empty($this->_request)){
            $post = $this->_request->getPost();
            $user = User::findFirst(array(
                "email = :username:",
                'bind' => array('username' => $post['username'])
            ));
            if (!$user)
                $this->setError("Such user does not exist", 2);
            elseif ($user->password != sha1($post['password']))
                $this->setError("Wrong password", 3);
            elseif (!$user->activity)
                $this->setError("This user inactive", 4);
            elseif (!in_array($user->user_type, ['user']))
                $this->setError("You do not have sufficient permissions to access this area", 5);
            else {
                $userIosappHash = UserIosappHashes::findFirstByUserId($user->id);
                if (!$userIosappHash) $userIosappHash = new UserIosappHashes();
                $userIosappHash->user_id = $user->id;
                $userIosappHash->setDates();
                $userIosappHash->generateHash();
                if ($userIosappHash->save() !== false) {
                    $this->setResultInfo('hash', $userIosappHash->hash);
                    return true;
                } else {
                    $errorsList = $userIosappHash->getMessages();
                    $errorsArr = [];
                    foreach($errorsList as $error)
                        $errorsArr[] =$error->__toString();
                    $this->setError($errorsArr, 4);
                }
            }
        } else
            $this->setError('No auth data set', 1);
        return false;

    }
}