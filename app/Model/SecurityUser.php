<?php

namespace app\Model;

use app\Model\GeneralAuditrail;

class SecurityUser extends GeneralAuditrail {

    protected $email = 'email';
    protected $password = 'password';
    protected $groupId = 'group_id';
    protected $salt = 'salt';
    protected $approved = 'approved';
    protected $expiredDate = 'expired_date';

    public function __construct() {
        $this->setEntity('sec_user');
    }

    function getExpiredDate() {
        return $this->expiredDate;
    }

    function setExpiredDate($expiredDate) {
        $this->expiredDate = $expiredDate;
    }

    function getEmail() {
        return $this->email;
    }

    function setEmail($email) {
        $this->email = $email;
    }

    function getGroupId() {
        return $this->groupId;
    }

    function setGroupId($groupId) {
        $this->groupId = $groupId;
    }

    function getPassword() {
        return $this->password;
    }

    function getGroup() {
        return new SecurityGroup();
//        return $this->group;
    }

    function getSalt() {
        return $this->salt;
    }

    function getApproved() {
        return $this->approved;
    }

    function setPassword($password) {
        $this->password = $password;
    }

    function setGroup($group) {
//        $this->group = $group;
    }

    function setSalt($salt) {
        $this->salt = $salt;
    }

    function setApproved($approved) {
        $this->approved = $approved;
    }

    public function search($key) {
//        parent::search($key);
        if(isset($this->$key)){
            return $this->$key;
        } else {
            return "";
        }
    }

    function setData($data) {
        $array_data = array();
        foreach ($data as $key => $value) {
            $array_data[$this->$key] = $value;
            echo $this->$key.'<br/>';
        }
        return $array_data;
    }
    
    

}
