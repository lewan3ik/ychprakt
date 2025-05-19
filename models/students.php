<?php

class students{
    public $id;
    public $lastName;
    public $firstName;
    public $subName;
    public $dateKick;
    public $groupId;
    public $login;
    public $password;
    public function __construct($id, $lastName, $firstName, $subName, $dateKick, $groupId, $login, $password) {
        $this->id = $id;
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->subName = $subName;
        $this->dateKick = $dateKick;
        $this->groupId = $groupId;
        $this->login = $login;
        $this->password = $password;
    }
}
?>