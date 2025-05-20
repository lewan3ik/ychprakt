<?php

class consultation{
    public $ID;
    public $Date;
    public $GroupID;
    public $TeacherID;
public function __construct($ID, $Date, $GroupID, $TeacherID) {
        $this->ID = $ID;
        $this->Date = $Date;
        $this->GroupID = $GroupID;
        $this->TeacherID = $TeacherID;
    }
}
?>