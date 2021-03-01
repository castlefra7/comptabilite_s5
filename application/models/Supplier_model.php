<?php

class Supplier_model extends Base_Model
{
    public $id;
    public $name;


    public function getAllSuppliers()
    {
        $sql = "select * from suppliers";
        $query = $this->db->query($sql);
        $result = array();
        foreach ($query->result_array() as $row) {
            $newObject = arrayToObject($row, $this);
            $result[] = $newObject;
        }
        return $result;
    }
}
