<?php

class Cmup_model extends Base_Model {
    public $id;
    public $product_id;
    public $amount;
    public $date_cmup;

    public function calculateCmup($product_id) {
        $sql = "select ((select sum(amount) from inventory_in where product_id = %d) - (select sum(amount) from inventory_out where product_id = %d)) / ((select sum(quantity) from inventory_in where product_id = %d) - (select sum(quantity) from inventory_out where product_id = %d)) as cmup";
        $sql = sprintf($sql, $product_id, $product_id, $product_id, $product_id);
        $query = $this->db->query($sql);
        $row = $query->row_array();
        if($row) {
            return $row["cmup"];
        }
        return 0;
    }

    public function insert() {
        $sql = "insert into cmup (product_id, amount, date_cmup) values (%d, %d, %s)";
        $sql = sprintf($sql,$this->id, $this->amount, $this->date_cmup);
        $this->db->query($sql);
    }

    public function getLastCmup($product_id) {
        $sql = "select * from cmup where product_id = %d order by date_cmup desc limit 1";
        $sql = sprintf($sql, $product_id);
        $query = $this->db->query($sql);
        $row = $query->row_array();
        $newObject = arrayToObject($row, $this);
        return $newObject;
    }

    public function fifo($all_entries_date_asc, $quantity_out, $quantity_left, $sommeQteSortie) {
        $length = count($all_entries_date_asc);
        $current_quantity = $quantity_left - $quantity_out;
        $result = 0;
        if($current_quantity == $quantity_out) {
            return $quantity_out * $all_entries_date_asc[$length-1]->unit_price;
        }

        if($current_quantity > $quantity_out) {
            $iO = 0;
            $currObj = $all_entries_date_asc[$iO];   
            // 1ere phase: Move to the correct entree
            if($sommeQteSortie > 0) {
                $totQteEntree = 0;
                for($iD = 0; $iD < $length; $iD++) {
                    $totQteEntree += $all_entries_date_asc[$iD]->quantity;
                    if($totQteEntree > $sommeQteSortie) {
                        $currObj = $all_entries_date_asc[$iD];
                        $iO = $iD;
                        $currObj->quantity = $totQteEntree - $sommeQteSortie;
                        break;
                    } else if($totQteEntree == $sommeQteSortie) {
                        $iD++;
                        $currObj = $all_entries_date_asc[$iD];
                        $iO = $iD;
                        break;
                    }
                }
            }
            // 2eme phase: calculer le FIFO
            $montantFinal = 0;
            while($iO < $length) {
                if($currObj->quantite >= $quantity_out) {
                    $montantFinal += ($quantity_out * $currObj->unit_price);
                    break;
                } else {
                    $montantFinal += ($currObj->quantity * $currObj->unit_price);
                    $quantity_out = ($quantity_out - $currObj->quantity);
                    $iO++;
                    $currObj = $all_entries_date_asc[$iO];   
                }
            }
            $result = $montantFinal;
        }
        return $result;
    }
}