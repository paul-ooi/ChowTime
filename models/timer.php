<?php

class Timer {
    private $name;
    // private $hours;
    // private $minutes;
    // private $seconds;
    private $origTime;


    public function getName() {
        return $this->name;
    }
    public function setName($param) {
        $this->name = $param;
    }

    // public function getHours() {
    //     return $this->hours;
    // }
    // public function setHours($param) {
    //     $this->hours = $param;
    // }
    //
    // public function getMinutes() {
    //     return $this->minutes;
    // }
    // public function setMinutes($param) {
    //     $this->minutes = $param;
    // }
    //
    // public function getSeconds() {
    //     return $this->seconds;
    // }
    // public function setSeconds($param) {
    //     $this->seconds = $param;
    // }

    public function getOrigTime() {
        return $this->origTime;
    }
    public function setOrigTime($param) {
        $this->origTime = $param;
    }

    public function isValid($hh, $mm, $ss, $name = 'untitled timer') {
        $flag = true;
        if (gmp_sign($hh) == -1 | gmp_sign($mm) == -1 | gmp_sign($ss) == -1 ) {
            return false; //entry cannot be zero
        }



        return $flag;
    }

    public function __construct($hh = 0, $mm = 0, $ss = 0, $name = 'untitled') {
        $this->setName($name);
        $totalSeconds = (intval($hh) * 60 * 60) + (intval($mm) * 60) + intval($ss);

        $this->setOrigTime($totalSeconds);
    }

}

 ?>
