<?php

class GenAmortissement {
    public function generateAmortissementDeg($immo, $period) {
        $result = array();
        $firstAmmort = new AmortissementDegressif();
        $firstAmmort->setId(0);
        $firstAmmort->setImmo($immo);
        $firstAmmort->setPeriod($period);
        $reverse_id= $firstAmmort->getNumberPeriod();
        $firstAmmort->setReverse_id($reverse_id);
        $firstAmmort->setBegin_date(new DateTime($immo->usage_date));
        $firstAmmort->setFirst_ammort($firstAmmort);

        $result[] = $firstAmmort;

        $prev_date = $firstAmmort->getBegin_date();
        $prev_cumul_fin = $firstAmmort->getCumulFin();
        $prev_net_value = $firstAmmort->getValeurNette();
        for($i = 0; $i < $firstAmmort->getNumberPeriod(); $i++) {
            $reverse_id--;
            if($reverse_id == 0) break;
            $ammort = new AmortissementDegressif();
            $ammort->setId($i + 1);
            $ammort->setImmo($immo);
            $ammort->setReverse_id($reverse_id);
            $ammort->setPeriod($period);
            $ammort->setPrev_cumule_fin($prev_cumul_fin);
            $ammort->setPrev_net_value($prev_net_value);
            $ammort->setFirst_ammort($firstAmmort);

            if($period == 1) {
                $ammort->setBegin_date(new DateTime(date("Y-m-d", strtotime("+1 years", strtotime($prev_date->format("y-m-d"))))));
            } else if($period == 2) {
                $ammort->setBegin_date(new DateTime(date("Y-m-d", strtotime("+1 months", strtotime($prev_date->format("y-m-d"))))));
            } else if ($period == 3) {
                $ammort->setBegin_date(new DateTime(date("Y-m-d", strtotime("+1 days", strtotime($prev_date->format("y-m-d"))))));
            }

            $prev_net_value = $ammort->getValeurNette();
            $prev_cumul_fin = $ammort->getCumulFin();
            $prev_date = $ammort->getBegin_date();

            $result[] = $ammort;
        }
        return $result;
    }

    public function generateAmortissement($immo, $period) {
        $result = array();
        $firstAmmort = new AmortissementLineaire();
        $firstAmmort->id= 0;
        $firstAmmort->setImmo($immo);
        $firstAmmort->period = $period;
        $firstAmmort->first_ammort = null;
        $firstAmmort->begin_date = new DateTime($immo->usage_date);
        $result[] = $firstAmmort;

        $prev_date = $firstAmmort->begin_date;
        $prev_cumul_fin = $firstAmmort->getCumulFin();
        $how_many_zeroes = 0;
        for($i = 0; $i < $firstAmmort->getNumberPeriod(); $i++) {       
            $ammort = new AmortissementLineaire();
            $ammort->id= $i + 1;
            $ammort->setImmo($immo);
            $ammort->period = $period;
            $ammort->first_ammort = $firstAmmort;
            $ammort->prev_cumule_fin = $prev_cumul_fin;
            if($period == 1) {
                $ammort->begin_date = new DateTime(date("Y-m-d", strtotime("+1 years", strtotime($prev_date->format("y-m-d")))));
            } else if ($period == 2) {
                $ammort->begin_date = new DateTime(date("Y-m-d", strtotime("+1 months", strtotime($prev_date->format("y-m-d")))));
            } else if($period == 3) {
                $ammort->begin_date = new DateTime(date("Y-m-d", strtotime("+1 days", strtotime($prev_date->format("y-m-d")))));
            }

            $prev_date = $ammort->begin_date;
            $prev_cumul_fin = $ammort->getCumulFin();
            if($ammort->getValeurNette() == 0) $how_many_zeroes++;
            if($how_many_zeroes > 1) break;
            $result[] = $ammort;
            if($ammort->getValeurNette() < 0) break;

        }
        return $result;
    }
}