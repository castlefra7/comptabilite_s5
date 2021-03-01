<?php

class Inv_model extends Base_Model {
    public $id;
    public $immo_id;
    public $inv_date;
    public $inv_state;
    public $description;


    public function __toString()
    {
        return "Date: " .$this->getInv_date() . ". Etat: " . $this->getInv_state();
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
     * Get the value of inv_date
     */ 
    public function getInv_date()
    {
        return $this->inv_date;
    }

    /**
     * Get the value of inv_state
     */ 
    public function getInv_state()
    {
        return $this->inv_state;
    }

    /**
     * Get the value of description
     */ 
    public function getDescription()
    {
        return $this->description;
    }
}