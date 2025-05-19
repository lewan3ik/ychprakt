<?php

class progarmDiscipline{
    public $id;
    public $theme;
    public $tipy;
    public $hours;
    public $disciplineId;
    public function __construct($id, $theme, $tipy, $hours, $disciplineId) {
        $this->id = $id;
        $this->theme = $theme;
        $this->tipy = $tipy;
        $this->hours = $hours;
        $this->disciplineId = $disciplineId;
    }
}
?>