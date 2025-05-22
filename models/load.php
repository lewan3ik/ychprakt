<?php

class load{
    public $ID;
    public $DisciplineID;
    public $GroupID;
    public $TeacherID;
    public $Hours;
    public function __construct($ID, $disciplineId, $groupId, $teacherId, $Hours) {
        $this->ID = $ID;
        $this->DisciplineID = $disciplineId;
        $this->GroupID = $groupId;
        $this->TeacherID = $teacherId;
        $this->Hours = $Hours;
    }
}
?>