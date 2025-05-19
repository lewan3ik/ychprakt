<?php

class load{
    public $id;
    public $disciplineId;
    public $groupId;
    public $teacherId;
    public $Hours;
    public function __construct($id, $disciplineId, $groupId, $teacherId, $Hours) {
        $this->id = $id;
        $this->disciplineId = $disciplineId;
        $this->groupId = $groupId;
        $this->teacherId = $teacherId;
        $this->Hours = $Hours;
    }
}
?>