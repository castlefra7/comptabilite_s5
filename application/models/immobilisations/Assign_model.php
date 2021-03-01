<?php

class Assign_model extends Base_Model {
    public $id;
    public $immo_id;
    public $assign_date;
    public $service_id;
    public $description;
    public $service_name;

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
}