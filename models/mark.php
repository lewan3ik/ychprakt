<?php
class mark{
    public $id;
    public $studentId;
    public $leassonId;
    public $mark;
    public function __construct($id, $studentId, $leassonId, $mark) {
        $this->id = $id;
        $this->studentId = $studentId;
        $this->leassonId = $leassonId;
        $this->mark = $mark;
    }
}
?>