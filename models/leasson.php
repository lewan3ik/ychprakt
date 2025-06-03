<?php

class leasson {
    public $id;
    public $date;
    public $loadId;
    public $programmId;
    public function __construct($id, $date, $loadId, $programmId) {
        $this->ID = $id;
        $this->date = $date;
        $this->loadId = $loadId;
        $this->programmId = $programmId;
    }
}
?>