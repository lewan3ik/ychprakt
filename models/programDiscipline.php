<?php

class progarmDiscipline{
    public $ID;
    public $Topic;
    public $ClassType;
    public $Hours;
    public $DisciplineID;
    public function __construct($ID, $Topic, $ClassType, $Hours, $DisciplineID) {
        $this->ID = $ID;
        $this->Topic = $Topic;
        $this->ClassType = $ClassType;
        $this->Hours = $Hours;
        $this->DisciplineID = $DisciplineID;
    }
}
?>