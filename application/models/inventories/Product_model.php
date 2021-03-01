<?php
require "Cmup_model.php";

class Product_model extends Base_Model
{
    public $id;
    public $code;
    public $name;
    public $inventory_method;


    public function instantiate($_code, $_name, $_method) {
        $new_product = new Product_model();
        $new_product->code = $_code;
        $new_product->name = $_name;
        $new_product->inventory_method = $_method;
        return $new_product;
    }

    public function insert() {
        $sql = "insert into products (code, name, inventory_method) values (%s, %s, %s)";
        $sql = sprintf($sql, $this->db->escape($this->getCode()), $this->db->escape($this->getName()), $this->db->escape($this->getInventory_method()));
        $this->db->query($sql);
    }

    public function insertIn($_product_id, $_date, $_quantity, $_unit_price)
    {
        $product = $this->getProduct($_product_id);

        if ($product->inventory_method == 'CMUP') {
            $new_Cmup = new Cmup_model();
            $cmupValue = $new_Cmup->calculateCmup($_product_id,  $_unit_price);
            $new_Cmup->product_id = $product->id;
            $new_Cmup->amount = $cmupValue;
            $new_Cmup->date_cmup = $_date;

            $new_Cmup->insert();
        }

        $inv_in = new Inventory_model();
        $inv_in->product_id = $_product_id;
        $inv_in->unit_price = $_unit_price;
        $inv_in->quantity = $_quantity;
        $inv_in->amount = $_quantity * $_unit_price;
        $inv_in->date_inv = $_date;
        $inv_in->insertInventoryIn();
    }


    public function insertOut($_product_id, $_date, $_quantity = 0)
    {
        // var_dump($_product_id, $_date,$_quantity);
        $product = $this->getProduct($_product_id);
        $product_info = $this->getInfo($_product_id);

        $cmup_model = new Cmup_Model();

        $new_out = new Inventory_model();
        $new_out->product_id = $_product_id;
        $new_out->quantity = $_quantity;
        $new_out->date_inv = $_date;

        // TODO check if current quantity >= out quantity

        if ($product->inventory_method == 'CMUP') {
            $last_cmup = $cmup_model->getLastCmup($_product_id);
            if ($last_cmup == null) throw new Exception("TABLE CMUP est vide");
            $new_out->amount = $_quantity * $last_cmup->amount;
            $new_out->unit_price = $last_cmup->amount;
        } else  {
            $inv_model = new Inventory_model();
            $sumQuantityOut = $this->getSumQuantityOut($_product_id);
            $amount_fifo = $cmup_model->fifo($inv_model->getAllEntriesForFifo($_product_id), $_quantity, $product_info->quantity, $sumQuantityOut);

            $new_out->amount = $amount_fifo;
            $new_out->unit_price = $amount_fifo / $_quantity;

        }

        $new_out->insertInventoryOut();
    }

    public function getSumQuantityOut($_product_id)
    {
        $sql = "select sum(quantity) as sum from inventory_out where product_id = %d";
        $sql = sprintf($sql, $_product_id);
        $query = $this->db->query($sql);
        $row = $query->row_array();
        if ($row) {
            return $row["sum"];
        }
        return 0;
    }

    public function getInfo($_product_id)
    {
        $sql = "select (select ((select coalesce(sum(amount),0) as sum_ins from inventory_in where product_id = %d) - (select coalesce(sum(amount), 0) as sum_out from inventory_out where product_id = %d)))  as amount, ((select coalesce(sum(quantity),0) as sum_ins from inventory_in where product_id = %d) - (select coalesce(sum(quantity),0) as sum_out from inventory_out where product_id = %d)) as quantity, -1 as unit_price, %d as product_id;";
        $sql = sprintf($sql, $_product_id, $_product_id, $_product_id, $_product_id, $_product_id);
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $newObject = arrayToObject($row, new InventoryInfo_model());

        if ($newObject->quantity != 0) {
            $newObject->unit_price = $newObject->amount / $newObject->quantity;
        }


        return $newObject;
    }

    public function getProduct($_id)
    {
        $sql = "select * from products where id = %d";
        $sql = sprintf($sql, $_id);
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $newObject = arrayToObject($row, $this);
        return $newObject;
    }

    public function getAllProducts()
    {
        $sql = "select * from products";
        $query = $this->db->query($sql);
        $result = array();
        foreach ($query->result_array() as $row) {
            $newObject = arrayToObject($row, $this);
            $result[] = $newObject;
        }
        return $result;
    }

    /**
     * Get the value of code
     */ 
    public function getCode()
    {
        return $this->code;
    }

    /**
     * Set the value of code
     *
     * @return  self
     */ 
    public function setCode($code)
    {
        $this->code = $code;

        return $this;
    }

    /**
     * Get the value of name
     */ 
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @return  self
     */ 
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get the value of inventory_method
     */ 
    public function getInventory_method()
    {
        return $this->inventory_method;
    }

    /**
     * Set the value of inventory_method
     *
     * @return  self
     */ 
    public function setInventory_method($inventory_method)
    {
        $this->inventory_method = $inventory_method;

        return $this;
    }
}
