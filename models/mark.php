<?php
class mark{
    public $id;
    public $studentId;
    public $leassonId;
    public $mark;
    public function __construct($id, $studentId, $lessonId, $grade) {
        $this->id = $id;
        $this->studentId = $studentId;
        $this->lessonId = $lessonId;
        $this->grade = $grade;
    }
}
?>