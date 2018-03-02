<?php
class Validation {
    // Email Validation - Sophia Vong
    public function email($emailParam){
        $emailRegex = '/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/';
        $emailMatch = preg_match($emailRegex, $emailParam);
        return $emailMatch; // Returns 1 or 0 for true or false
    }

    // Numbers Only Validation - Sophia Vong
    public function number($numbParam){
        $numbRegex = '/^\d+$/';
        $numbMatch = preg_match($numbRegex, $numbParam);
        return $numbMatch; // Returns 1 or 0 for true or false
    }
}
