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

    public function instantiate($_immo_id, $_repairer, $_date, $_desc) {
        $new_maint = new Maintenance_model();
        $new_maint->immo_id = $_immo_id;
        $new_maint->description_repairer = $_repairer;
        $new_maint->description_maintenance = $_desc;
        $new_maint->maintenance_date_begin = $_date;
        $new_maint->maintenance_date_end = $_date;
        return $new_maint;
    }

    public function insert() {
        $sql = "insert into maintenance_history(immo_id, description_repairer, maintenance_date_begin, maintenance_date_end, description_maintenance) values (%d, %s, %s, %s, %s)";
        $sql = sprintf($sql, $this->immo_id, $this->db->escape($this->description_repairer), $this->db->escape($this->maintenance_date_begin), $this->db->escape($this->maintenance_date_end), $this->db->escape($this->description_maintenance));
        $this->db->query($sql);

    }
    

    /**
     * Get the value of description_maintenance
     */ 
    public function getDescription_maintenance()
    {
        return $this->description_maintenance;
    }

    /**
     * Set the value of description_maintenance
     *
     * @return  self
     */ 
    public function setDescription_maintenance($description_maintenance)
    {
        $this->description_maintenance = $description_maintenance;

        return $this;
    }

    /**
     * Get the value of maintenance_date_end
     */ 
    public function getMaintenance_date_end()
    {
        return $this->maintenance_date_end;
    }

    /**
     * Set the value of maintenance_date_end
     *
     * @return  self
     */ 
    public function setMaintenance_date_end($maintenance_date_end)
    {
        $this->maintenance_date_end = $maintenance_date_end;

        return $this;
    }

    /**
     * Get the value of maintenance_date_begin
     */ 
    public function getMaintenance_date_begin()
    {
        return $this->maintenance_date_begin;
    }

    /**
     * Set the value of maintenance_date_begin
     *
     * @return  self
     */ 
    public function setMaintenance_date_begin($maintenance_date_begin)
    {
        $this->maintenance_date_begin = $maintenance_date_begin;

        return $this;
    }

    /**
     * Get the value of description_repairer
     */ 
    public function getDescription_repairer()
    {
        return $this->description_repairer;
    }

    /**
     * Set the value of description_repairer
     *
     * @return  self
     */ 
    public function setDescription_repairer($description_repairer)
    {
        $this->description_repairer = $description_repairer;

        return $this;
    }

    /**
     * Get the value of immo_id
     */ 
    public function getImmo_id()
    {
        return $this->immo_id;
    }

    /**
     * Set the value of immo_id
     *
     * @return  self
     */ 
    public function setImmo_id($immo_id)
    {
        $this->immo_id = $immo_id;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }
}