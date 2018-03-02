<?php

// VARIABLES TO SET
$btnName = 'submit';
$numCheck = 2; //Greater than or equal to

// BLANK VARIABLES
$inText = null;

// REGEX PATTERNS
$alpha = '/^[A-Za-z]+$/';


// ON SUBMIT, ASSIGN VALUES AND VALIDATE
if(isset($_POST[$btnName])) {

    $inCheckBoxArr = checkAssignProperty('drink');
    $inRadio = checkAssignProperty('radios');
    $inDropDown = checkAssignProperty('dropdowns');
    $inText = checkAssignProperty('fname');

    try {
        echo validateCheckBox($inCheckBoxArr, $numCheck, $drinks);
        echo validateAlphaOnly($alpha, $inText);
        echo validateDropdownRadio($inDropDown, $dropdowns);
        echo validateDropdownRadio($inRadio, $radios);
    }
    catch (Exception $e) {
        echo $e->getMessage();
    }
}

// CHECKBOX VALIDATION
function validateCheckBox($check, $numCheck, $arr) {
    // SEE IF SOMETHING HAS BEEN CHECKED
    if(empty($check)) {
        throw new Exception("Please select");
        return false;
    } if (!(count($check) >= $numCheck)) {
        throw new Exception("Please select at least two");
        return false;
    }
        else {
        // CHECK THAT SELECTED VALUES ARE ACTUALLY VALUES FROM THE CHECKBOX ARRAY
        foreach($check as $keyCheck => $valCheck) {
            foreach($arr as $key => $value) {
                if($keyCheck == $key) {
                    return 1;
                }
            }
        }
    }
}

// ALPHA ONLY VALIDATION
function validateAlphaOnly($regEx, $text) {
    if(empty($text)) {
        throw new Exception("Please enter text");
        return false;
    } else if (!preg_match($regEx, $text)) {
        throw new Exception("Please enter valid text");
        return false;
    } else {
        return 1;
    }
}

// DROPDOWN VALIDATION
function validateDropdownRadio($selected, $arr) {
    if(empty($selected)) {
        throw new Exception("Please select");
        return false;
    } else {
        foreach($arr as $key => $value) {
            if($selected == $key) {
                return 1;
            }
        }
    }
}

// CHECK IF PROPERTY HAS BEEN SET, THEN RETURN THE VALUES INPUT OF THE POST
function checkAssignProperty($name) {
    if(!empty($_POST[$name])) {
        return $_POST[$name];
    } else {
        return null;
    }
}

?>
