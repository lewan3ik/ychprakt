<?php

class students{
    public $ID;
    public $FullName;
    public $ExpulsionDate;
    public $GroupID;
    public $login;
    public $password;
    public function __construct($id, $FullName,$login,$password, $ExpulsionDate, $groupId) {
        $this->ID = $id;
        $this->FullName = $FullName;
        $this->ExpulsionDate = $ExpulsionDate;
        $this->GroupID = $groupId;
        $this->login = $login;
        $this->password = $password;
    }
}
?>