<?php

class Inv_model extends Base_Model {
    public $id;
    public $immo_id;
    public $inv_date;
    public $inv_state;
    public $description;


    public function instantiate($_immo_id, $_inv_date, $_inv_state, $_desc) {
        $new_inv = new Inv_model();
        $new_inv->immo_id = $_immo_id;
        $new_inv->inv_date = $_inv_date;
        $new_inv->inv_state = $_inv_state;
        $new_inv->description = $_desc;
        return $new_inv;
    }

    public function insert() {
        $sql = "insert into inventories (immo_id, inv_date, inv_state, description) values (%d, %s, %s, %s)";
        $sql = sprintf($sql, $this->immo_id, $this->db->escape($this->inv_date), $this->db->escape($this->inv_state), $this->db->escape($this->description));
        $this->db->query($sql);
    }

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