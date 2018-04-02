<?php

class Timer {
    private $name;
    private $hours;
    private $minutes;
    private $seconds;

    public function getName() {
        return $this->name;
    }
    public function setName($param) {
        $this->name = $param;
    }

    public function getHours() {
        return $this->hours;
    }
    public function setHours($param) {
        $this->hours = $param;
    }

    public function getMinutes() {
        return $this->minutes;
    }
    public function setMinutes($param) {
        $this->minutes = $param;
    }

    public function getSeconds() {
        return $this->seconds;
    }
    public function setSeconds($param) {
        $this->seconds = $param;
    }

    public function isValid($hh, $mm, $ss, $name = 'untitled timer') {
        $flag = true;
        if (gmp_sign($hh) == -1 | gmp_sign($mm) == -1 | gmp_sign($ss) == -1 ) {
            return false; //entry cannot be zero
        }



        return $flag;
    }

}

 ?>
