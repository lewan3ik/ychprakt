<?php
class mark{
    public $ID;
    public $StudentID;
    public $LessonID;
    public $Grade;
    public $Date;
    public function __construct($ID, $StudentID, $LessonID, $Grade,$Date) {
        $this->ID = $ID;
        $this->StudentID = $StudentID;
        $this->LessonID = $LessonID;
        $this->Grade = $Grade;
        $this->Date = $Date;
    }
}
?>