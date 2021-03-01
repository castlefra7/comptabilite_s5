<?php

class Immo_model extends Base_Model
{
    public $id;
    public $code;
    public $designation;
    public $buy_date;
    public $usage_date;
    public $supplier_id;
    public $buy_price;
    public $amortissed_year;
    public $amortissed_rate;
    public $amortissed_type;
    public $coefficient;
    public $supplier_name;


    public function instantiate($code, $designation, $buy_date, $usage_date, $buy_price, $amortissed_year, $amortissed_type, $supplier_id, $coefficient) {
        $new_immo = new Immo_model();
        $new_immo->code = $code;
        $new_immo->designation = $designation;
        $new_immo->buy_date = $buy_date;
        $new_immo->usage_date = $usage_date;
        $new_immo->buy_price = $buy_price;
        $new_immo->amortissed_year = $amortissed_year;
        $new_immo->amortissed_rate = (100/$amortissed_year)/100;
        $new_immo->amortissed_type = $amortissed_type;
        $new_immo->supplier_id = $supplier_id;
        $new_immo->coefficient = $coefficient;
        return $new_immo;
    }

    public function getInventoryHistory($_code) {
        $sql = "select inventories.* from inventories join immobilisations on immobilisations.id = inventories.immo_id  where immobilisations.code = %s";
        $sql = sprintf($sql, $this->db->escape($_code));

        $query = $this->db->query($sql);
        $result = array();
        foreach ($query->result_array() as $row) {
            $newObject = arrayToObject($row, new Inv_model());
            $result[] = $newObject;
        }
        return $result;
    }

    public function geMaintHistory($_code) {
        $sql = "select maintenance_history.* from maintenance_history join immobilisations on immobilisations.id = maintenance_history.immo_id  where immobilisations.code = %s";
        $sql = sprintf($sql, $this->db->escape($_code));

        $query = $this->db->query($sql);
        $result = array();
        foreach ($query->result_array() as $row) {
            $newObject = arrayToObject($row, new Maintenance_model());
            $result[] = $newObject;
        }
        return $result;
    }

    public function getAssignHistory($_code) {
        $sql = "select assignment_history.*, services.name as service_name from assignment_history join immobilisations on immobilisations.id = assignment_history.immo_id join services on services.id = assignment_history.service_id  where immobilisations.code = %s";
        $sql = sprintf($sql, $this->db->escape($_code));

        $query = $this->db->query($sql);
        $result = array();
        foreach ($query->result_array() as $row) {
            $newObject = arrayToObject($row, new Assign_model());
            $result[] = $newObject;
        }
        return $result;
    }

    public function insert() {
        $sql = "insert into immobilisations (code, designation, buy_date, usage_date, supplier_id, buy_price, amortissed_year, amortissed_rate, amortissed_type) values 
        (%s, %s, %s, %s, %d, %d, %d, %d, %d)";
        $sql = sprintf($sql, $this->db->escape($this->getCode()), $this->db->escape($this->getDesignation()), $this->db->escape($this->getBuy_date()), $this->db->escape($this->getUsage_date()), $this->getSupplier_id(), $this->getBuy_price(), $this->getAmortissed_year(), $this->getAmortissed_rate(), $this->getAmortissed_type());
        $this->db->query($sql);
    }

    public function getCurrentAmount($code, $date) {
        $immo = $this->getImmo($code);
        $result = 0;
        if($immo->getAmortissed_type() == 1) {
            $ammorts = $this->getAmortissementsLineaire($code, 3);
            foreach($ammorts as $ammort)  {
                if($ammort->begin_date->format("Y-m-d") == $date) {
                    $result = $ammort->getValeurNette();
                    break;
                }
            }
        }
        if($immo->getAmortissed_type() == 2) {
            $ammorts = $this->getAmortissementsDegressif($code, 3);
            foreach($ammorts as $ammort)  {
                if($ammort->begin_date->format("Y-m-d") == $date) {
                    $result = $ammort->getValeurNette();
                    break;
                }
            }
        }
        return $result;
    }

    public function getLastMaintenance($code) {
        $sql = "select maintenance_history.* from maintenance_history join immobilisations on immobilisations.id =maintenance_history.immo_id  where immobilisations.code = %s order by maintenance_history.maintenance_date_begin desc limit 1";
        $sql = sprintf($sql, $this->db->escape($code));
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $ob = new Maintenance_model();
        $newObject = arrayToObject($row, $ob);
        return $newObject;
    }
    
    public function getLastAssign($code)
    {
        $sql = "select assignment_history.*, services.name as service_name from assignment_history join immobilisations on immobilisations.id =assignment_history.immo_id join services on services.id  = assignment_history.service_id  where immobilisations.code = %s order by assignment_history.assign_date desc limit 1";
        $sql = sprintf($sql, $this->db->escape($code));
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $ob = new Assign_model();
        $newObject = arrayToObject($row, $ob);
        return $newObject;
    }
    

    public function getLastInv($code)
    {
        $sql = "select inventories.* from inventories join immobilisations on immobilisations.id =inventories.immo_id  where immobilisations.code = %s order by inventories.inv_date desc limit 1";
        $sql = sprintf($sql, $this->db->escape($code));
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $ob = new Inv_model();
        $newObject = arrayToObject($row, $ob);
        return $newObject;
    }

    public function getAmortissementsDegressif($code, $period) {
        date_default_timezone_set("Africa/Nairobi");
        $immo = $this->getImmo($code);
        $gen =  new GenAmortissement();
        return $gen->generateAmortissementDeg($immo, $period);
    }


    public function getAmortissementsLineaire($code, $period) {
        date_default_timezone_set("Africa/Nairobi");
        $immo = $this->getImmo($code);
        $gen =  new GenAmortissement();
        return $gen->generateAmortissement($immo, $period);
    }


    public function getImmo($code)
    {
        $sql = "select immobilisations.*, suppliers.name as supplier_name from immobilisations join suppliers on suppliers.id = immobilisations.supplier_id where immobilisations.code = %s";
        $sql = sprintf($sql, $this->db->escape($code));
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $newObject = arrayToObject($row, $this);
        return $newObject;
    }

    public function getAllImo()
    {
        $sql = "select *, '' as supplier_name from immobilisations";
        $query = $this->db->query($sql);
        $result = array();
        foreach ($query->result_array() as $row) {
            $newObject = arrayToObject($row, $this);
            $result[] = $newObject;
        }
        return $result;
    }

    /**
     * Get the value of id
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Get the value of code
     */
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Get the value of designation
     */
    public function getDesignation()
    {
        return $this->designation;
    }

    /**
     * Get the value of buy_date
     */
    public function getBuy_date()
    {
        return $this->buy_date;
    }

    /**
     * Get the value of usage_date
     */
    public function getUsage_date()
    {
        return $this->usage_date;
    }

    /**
     * Get the value of supplier_id
     */
    public function getSupplier_id()
    {
        return $this->supplier_id;
    }

    /**
     * Get the value of buy_price
     */
    public function getBuy_price()
    {
        return $this->buy_price;
    }

    /**
     * Get the value of amortissed_year
     */
    public function getAmortissed_year()
    {
        return $this->amortissed_year;
    }

    /**
     * Get the value of amortissed_rate
     */
    public function getAmortissed_rate()
    {
        return $this->amortissed_rate;
    }

    /**
     * Get the value of amortissed_type
     */
    public function getAmortissed_type()
    {
        return $this->amortissed_type;
    }
}
