<?php

class Assign_model extends Base_Model {
    public $id;
    public $immo_id;
    public $assign_date;
    public $service_id;
    public $description;
    public $service_name;

    public function instantiate($_immo_id, $_assign_date, $_service_id, $_desc) {
        $new_assign = new Assign_model();
        $new_assign->immo_id = $_immo_id;
        $new_assign->assign_date = $_assign_date;
        $new_assign->service_id = $_service_id;
        $new_assign->setDescription($_desc);
        return $new_assign;
    }
    
    public function insert() {
        $sql = "insert into assignment_history (immo_id, assign_date, service_id, description) values (%d, %s, %d, %s)";
        $sql = sprintf($sql, $this->immo_id, $this->db->escape($this->assign_date), $this->service_id,  $this->db->escape($this->description));
        $this->db->query($sql);
    }

    public function __toString()
    {
        return "Date: " . $this->getAssign_date() . " Service: " . $this->service_name;
    }

    /** 
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of immo_id
     */ 
    public function getImmo_id()
    {
        return $this->immo_id;
    }

    /**
     * Get the value of assign_date
     */ 
    public function getAssign_date()
    {
        return $this->assign_date;
    }

    /**
     * Get the value of service_id
     */ 
    public function getService_id()
    {
        return $this->service_id;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Get the value of service_name
     */ 
    public function getService_name()
    {
        return $this->service_name;
    }

    /**
     * Set the value of service_name
     *
     * @return  self
     */ 
    public function setService_name($service_name)
    {
        $this->service_name = $service_name;

        return $this;
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
     * Set the value of description
     *
     * @return  self
     */ 
    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }
}