<?php

class consultation{
    public $id;
    public $date;
    public $groupId;
    public $teacherId;
public function __construct($id, $date, $groupId, $teacherId) {
        $this->id = $id;
        $this->date = $date;
        $this->groupId = $groupId;
        $this->teacherId = $teacherId;
    }
}
?>