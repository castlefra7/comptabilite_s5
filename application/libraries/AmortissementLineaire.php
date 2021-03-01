<?php

class AmortissementLineaire {
    public $id;
    public $immo;
    public $period;
    public $first_ammort;
    
    public $prev_cumule_fin;
    public $end_date;
    public $begin_date;


    public function getNumberPeriod() {
        $result = 0;
        if($this->period == 1) $result = $this->getImmo()->amortissed_year;
        if($this->period == 2) $result = $this->getImmo()->amortissed_year * 12;
        if($this->period == 3) $result = $this->getImmo()->amortissed_year * 365; // todo
        return $result;
    }

    public function getTaux() {
        return (100/$this->getNumberPeriod()) / 100;
    }

    public function getDotation() {
        $result = $this->getImmo()->buy_price * $this->getTaux();
        $dt_usage = new DateTime($this->getImmo()->usage_date);
        if($this->period == 2) {
            if($this->id == 0) {
                $result = $result * getRemainingDaysInaMonth($dt_usage) / getNumberDaysInAMonth($dt_usage);
            }
            if($this->id == $this->getNumberPeriod()) {
                $result = $result - $this->first_ammort->getDotation();
            }
        }
        if($this->period == 1) {
            if($this->id == 0) {
                $result = $result * getNumberDaysDiff($dt_usage, new DateTime($dt_usage->format("Y")."-12-31")) / getNumberDaysInAYear($dt_usage);
            }
            if($this->id == $this->getNumberPeriod()) {
                $result = $result - $this->first_ammort->getDotation();
            }
        }
        return $result;
    }

    public function getCumulDebut() {
        if($this->id == 0) return 0;
        return $this->prev_cumule_fin;
    }
    
    public function getCumulFin() {
        return $this->getCumulDebut() + $this->getDotation();
    }

    public function getValeurNette() {
        $result = $this->getImmo()->buy_price - $this->getCumulFin();
        $epsilon = 0.000001;
        if($result < $epsilon) $result = 0;
        return $result;
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
}