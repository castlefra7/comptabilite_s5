<?php

class Inventory_model extends Base_Model
{
    public $id;
    public $product_id;
    public $unit_price;
    public $quantity;
    public $amount;
    public $date_inv;
    public $type;

    public function getAllEntries($product_id)
    {

        $sql = "select * from all_entries where product_id = %d order by date_inv desc";
        $sql = sprintf($sql, $product_id);
        $query = $this->db->query($sql);
        $result = array();
        foreach ($query->result_array() as $row) {
            $newObject = arrayToObject($row, $this);
            $result[] = $newObject;
        }
        return $result;
    }


    public function getAllEntriesForFifo($product_id)
    {

        $sql = "select * from all_entries where product_id = %d order by date_inv asc";
        $sql = sprintf($sql, $product_id);
        $query = $this->db->query($sql);
        $result = array();
        foreach ($query->result_array() as $row) {
            $newObject = arrayToObject($row, $this);
            $result[] = $newObject;
        }
        return $result;
    }
}
