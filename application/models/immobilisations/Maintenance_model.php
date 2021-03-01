<?php

class Maintenance_model extends Base_Model {
    public $id;
    public $immo_id;
    public $description_repairer;
    public $maintenance_date_begin;
    public $maintenance_date_end;
    public $description_maintenance;

    public function __toString()
    {
        return "Date: " . $this->maintenance_date_begin . " Description: " . $this->description_maintenance;
    }
}