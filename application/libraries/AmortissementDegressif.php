<?php

class AmortissementDegressif {
    public $id;
    public $reverse_id;
    public $immo;
    public $coefficient;
    public $period;
    public $prev_cumule_fin;
    public $prev_net_value;

    public $first_ammort;
    public $begin_date;
    public $end_date;

    public function getNumberPeriod() {
        $result = 0;
        if($this->getPeriod() == 1) $result = $this->getImmo()->amortissed_year;
        if($this->getPeriod() == 2) $result = $this->getImmo()->amortissed_year * 12;
        if($this->getPeriod() == 3) $result = $this->getImmo()->amortissed_year * 365; // todo
        return $result;
    }

    public function getTauxDegressif() {
        $result = $this->getImmo()->coefficient;
        if($this->getPeriod() == 1) $result = $result * $this->getImmo()->amortissed_rate;
        if($this->getPeriod() == 2) $result = $result * $this->getFirst_ammort()->getTauxLineaire();
        if($this->getPeriod() == 3) $result = $result * $this->getFirst_ammort()->getTauxLineaire();
        return $result ; 
    }

    public function getTauxLineaire() {
        return (100/$this->getReverse_id()) / 100;
    }

    public function getTaux() {
        return max($this->getTauxDegressif(), $this->getTauxLineaire());
    }

    public function getCumulDebut() {
        if($this->getId() == 0) return 0;
        return $this->getPrev_cumule_fin();
    }

    public function getDotation() {
        $result = $this->getInitialValue() * $this->getTaux();
        if($this->getPeriod() == 1) {
            if($this->getId() == 0) {
                $result = $result * (12-($this->getBegin_date()->format("m")) -1) / 12;
            }
        }
        return $result;
    }

    public function getCumulFin() {
        return $this->getCumulDebut() + $this->getDotation();
    }

    public function getInitialValue() {
        if($this->getId() == 0) return $this->getImmo()->buy_price;
        return $this->getPrev_net_value();
    }

    public function getValeurNette() {
        return $this->getInitialValue() - $this->getDotation();
    }

    /**
     * Get the value of immo
     */ 
    public function getImmo()
    {
        return $this->immo;
    }

    /**
     * Set the value of immo
     *
     * @return  self
     */ 
    public function setImmo($immo)
    {
        $this->immo = $immo;

        return $this;
    }

    /**
     * Get the value of prev_cumule_fin
     */ 
    public function getPrev_cumule_fin()
    {
        return $this->prev_cumule_fin;
    }

    /**
     * Set the value of prev_cumule_fin
     *
     * @return  self
     */ 
    public function setPrev_cumule_fin($prev_cumule_fin)
    {
        $this->prev_cumule_fin = $prev_cumule_fin;

        return $this;
    }

    /**
     * Get the value of prev_net_value
     */ 
    public function getPrev_net_value()
    {
        return $this->prev_net_value;
    }

    /**
     * Set the value of prev_net_value
     *
     * @return  self
     */ 
    public function setPrev_net_value($prev_net_value)
    {
        $this->prev_net_value = $prev_net_value;

        return $this;
    }

    /**
     * Get the value of period
     */ 
    public function getPeriod()
    {
        return $this->period;
    }

    /**
     * Set the value of period
     *
     * @return  self
     */ 
    public function setPeriod($period)
    {
        $this->period = $period;

        return $this;
    }

    /**
     * Get the value of id
     */ 
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set the value of id
     *
     * @return  self
     */ 
    public function setId($id)
    {
        $this->id = $id;

        return $this;
    }

    /**
     * Get the value of reverse_id
     */ 
    public function getReverse_id()
    {
        return $this->reverse_id;
    }

    /**
     * Set the value of reverse_id
     *
     * @return  self
     */ 
    public function setReverse_id($reverse_id)
    {
        $this->reverse_id = $reverse_id;

        return $this;
    }

    /**
     * Get the value of begin_date
     */ 
    public function getBegin_date()
    {
        return $this->begin_date;
    }

    /**
     * Set the value of begin_date
     *
     * @return  self
     */ 
    public function setBegin_date($begin_date)
    {
        $this->begin_date = $begin_date;

        return $this;
    }

    /**
     * Get the value of first_ammort
     */ 
    public function getFirst_ammort()
    {
        return $this->first_ammort;
    }

    /**
     * Set the value of first_ammort
     *
     * @return  self
     */ 
    public function setFirst_ammort($first_ammort)
    {
        $this->first_ammort = $first_ammort;

        return $this;
    }
}