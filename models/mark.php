<?php
class mark{
    public $ID;
    public $StudentID;
    public $LessonID;
    public $Grade;
    public function __construct($ID, $StudentID, $LessonID, $Grade) {
        $this->ID = $ID;
        $this->StudentID = $StudentID;
        $this->LessonID = $LessonID;
        $this->Grade = $Grade;
    }
}
?>