<?php

class teacher{
    public $id;
    public $FIO;
    public $login;
    public $password;
    public function __construct($id, $FIO, $login, $password) {
        $this->id = $id;
        $this->FIO = $FIO;
        $this->login = $login;
        $this->password = $password;
    }
}
?>