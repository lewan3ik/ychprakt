<?php

class teacher{
    public $ID;
    public $FullName;
    public $Login;
    public $Password;
    public function __construct($ID, $FullName, $Login, $Password) {
        $this->ID = $ID;
        $this->FullName = $FullName;
        $this->Login = $Login;
        $this->Password = $Password;
    }
}
?>