<?php

class skip {
    public $ID;
    public $StudentID;
    public $LessonID;
    public $Minutes;
    public $ExplanationFile;
    
    public function __construct($ID, $StudentID, $LessonID, $Minutes, $ExplanationFile = null) {
        $this->ID = $ID;
        $this->StudentID = $StudentID;
        $this->LessonID = $LessonID;
        $this->Minutes = $Minutes;
        $this->ExplanationFile = $ExplanationFile;
    }
}
?>