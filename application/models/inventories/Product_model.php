<?php
require "Cmup_model.php";

class Product_model extends Base_Model
{
    public $id;
    public $code;
    public $name;
    public $inventory_method;


    public function insertIn($_product_id, $_date, $_quantity, $_unit_price)
    {
        $product = $this->getProduct($_product_id);

        if ($product->inventory_method == 'CMUP') {
            $new_Cmup = new Cmup_model();
            $cmupValue = $new_Cmup->calculateCmup($_product_id);
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
        $product = $this->getProduct($_product_id);
        $product_info = $this->getInfo($_product_id);
        
        $cmup_model = new Cmup_Model();
        
        $new_out = new InventoryOut_model();
        $new_out->product_id = $_product_id;
        $new_out->quantity = $_quantity;
        $new_out->date_out = $_date;

        // TODO check if current quantity >= out quantity

        if ($product->inventory_method == 'CMUP') {
            $last_cmup = $cmup_model->getLastCmup($_product_id);
            if($last_cmup == null) throw new Exception("TABLE CMUP est vide");
            $new_out->amount = $_quantity * $last_cmup->amount;
            $new_out->unit_price = $last_cmup->amount;
            // var_dump($last_cmup);
        } else if($product->inventory_model == 'FIFO') {
            $inv_model = new Inventory_model();
            $sumQuantityOut = $this->getSumQuantityOut($_product_id);
            $amount_fifo = $cmup_model->fifo($inv_model->getAllEntriesForFifo($_product_id), $_quantity, $product_info->quantity, $sumQuantityOut);

            $new_out->amount = $amount_fifo;
            $new_out->unit_price = $amount_fifo / $_quantity;
        }

        // TODO insert into inventory out

    }

    public function getSumQuantityOut($_product_id) {
        $sql = "select sum(quantity) as sum from inventory_out where product_id = %d";
        $sql = sprintf($sql, $_product_id);
        $query = $this->db->query($sql);
        $row = $query->row_array();
        if($row) {
            return $row["sum"];
        }
        return 0;
    }

    public function getInfo($_product_id)
    {
        $product = $this->getProduct($_product_id);
        $sql = "select (select ((select sum(amount) as sum_ins from inventory_in where product_id = %d) - (select sum(amount) as sum_out from inventory_out where product_id = %d)))  as amount, ((select sum(quantity) as sum_ins from inventory_in where product_id = %d) - (select sum(quantity) as sum_out from inventory_out where product_id = %d)) as quantity, -1 as unit_price, %d as product_id;";
        $sql = sprintf($sql, $_product_id, $_product_id, $_product_id, $_product_id, $_product_id);
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $newObject = arrayToObject($row, new InventoryInfo_model());

        $newObject->unit_price = $newObject->amount / $newObject->quantity;

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
}
