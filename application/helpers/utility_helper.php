<?php
function asset_url() {
    return base_url() . "assets/";
}

function arrayToObject($array, $object) {
    if($array == null) return null;
    if(count($array) == 0) return null;
    if($object == null) return null;
    $reflect = new ReflectionClass($object);
    $properties = $reflect->getProperties();
    $newObject = $reflect->newInstance();
    foreach($properties as $info) {
        if($info->isPublic()) {
            foreach(array_keys($array) as $col) {
                if(strtolower($info->getName()) == strtolower($col)) {
                    $info->setValue($newObject, $array[$col]);
                }
            }
        }
    }
    return $newObject;
}

function getEndofMonth($date) {
    return date("t", strtotime($date->format("y-m-d")));
}

function getNumberDaysInAYear($date) {
    $year = $date->format("y");
    $begin = new DateTime($year . "-01-01");
    $end = new DateTime($year . "-12-31");
    return getNumberDaysDiff($begin, $end);
}

function getNumberDaysInAMonth($date) {
    return date("t", strtotime($date->format("y-m-d")));
}

function getRemainingDaysInaMonth($date) {
    return getNumberDaysInAMonth($date) - $date->format("d") + 1;
}

function getNumberDaysDiff($dt1, $dt2) {
    return $dt1->diff($dt2)->format("%a")+1;
}