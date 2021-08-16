<?php
namespace models;

use models\base;

class Year extends base\BaseYear {

    /**
     * @return \models\DayQuery
     */
    public function getDays() {
        return parent::getDays()->orderByDay();
    }

    public function  getFromDate()
    {
        $parts = explode('-',$this->name);
        return \DateTime::createFromFormat('Y-m-d H:i:s', $parts[0].'-09-01 00:00:00');
    }

    public function  getToDate()
    {
        $parts = explode('-',$this->name);
        return \DateTime::createFromFormat('Y-m-d H:i:s', $parts[1].'-05-31 23:59:59');
    }
}