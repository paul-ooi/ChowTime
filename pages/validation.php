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

    //Postal Code Validator - Paul Ooi
    //Takes in a value from the calling program and compares it to the RegEx of a Canadian postal code to verify input is correct. Returns a Boolean result. The function automatically assumes a null value if there's no value passed to the function and throws an appropriate error.
    public function postalCode($userInput = null) {
        $result = false;//Set the verification flag to false
        $pcRegex = "/^[A-Z][0-9][A-Z] ?[0-9][A-Z][0-9]$/i"; //Postal Code RegEx with and without the space in the middle, case-insensitive
        try {
            //Catch if there was no argument passed to the function
            if ($userInput == null) {
              throw new ArgumentCountError("There must be a value sent to the validator");
            }
            //Run pattern match and assign boolean to result
            $result = preg_match($pcRegex, $userInput);

        } //End Try Block
          catch (ArgumentCountError $error) {
            return $error->getMessage();
        } catch (Exception $error) {
            //Catch any other error
            echo 'There was an error: ' . $error->getMessage();
        } finally {
            return $result; //Return 1 or 0 for True or False
        }
    }//end postalCode function

    //Password Validator - Paul Ooi
    //Takes in a value from the calling program and compares it to the RegEx. Returns a Boolean result. The function automatically assumes a null value if there's no value passed to the function and throws an appropriate error.
    public function password($userInput = null) {
        $result = false;//Set the verification flag to false
        $passwordRegex = "/^(?=.*[[:digit:]])(?=.*[[:lower:]])(?=.*[[:upper:]])[[:alnum:]]{8,}$/"; //Password RegEx uses look-ahead assertions to require minimum 8 characters, one lowercase, one uppercase, one diigit
        try {
            //Catch if there was no argument passed to the function
            if ($userInput == null) {
                throw new ArgumentCountError("There must be a value sent to the validator");
          }

          //Catch if the userInput is not a valid string
          if (!is_string($userInput)) {
              throw new Exception("Value passed to validator is not a valid string");
          }

          //Run pattern match and assign boolean to result
          $result = preg_match($passwordRegex, $userInput);

          //If the Password is invalid, output message to user of potential fix
          if (!$result) {
              $digitRegex = "/(?=.*[[:digit:]])/";
              $lowerRegex = "/(?=.*[[:lower:]])/";
              $upperRegex = "/(?=.*[[:upper:]])/";

              if (strlen($userInput) < 8) {
                  echo "Password must contain at least 8 characters";
              } else if (!preg_match($digitRegex, $userInput)) {
                  echo "Password must contain at least 1 digit";
              } else if (!preg_match($lowerRegex, $userInput)) {
                  echo "Password must contain at least 1 lowercase character";
              } else if (!preg_match($upperRegex, $userInput)) {
                  echo "Password must contain at least 1 uppercase character";
              } else {
                  echo "Password can only contain numbers and letters.";
              }
          }// end IF to narrow down Password error

        }//End Try Block
          catch (ArgumentCountError $error) {
            return $error->getMessage();
        } catch (Exception $error) {
            //Catch any other error
            echo 'There was an error: ' . $error->getMessage();
        } finally {
            return $result; //Return 1 or 0 for True or False
        }
    }//end password function

// JESSICA WONG - CHECKBOX VALIDATION
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

// JESSICA WONG - DROPDOWN/RADIO VALIDATION
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

// JESSICA WONG - ALPHA ONLY VALIDATION
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

//JESSICA WONG - CHECK FOR EMPTY FIELDS
function checkAssignProperty($name) {
    if(!empty($_POST[$name])) {
        return $_POST[$name];
    } else {
        return null;
    }
}

function confirmPass($pass1, $pass2) //Brad Campbell
{
    if($pass1 === $pass2)
    {
        return 1;
    }
    else
    {
        //throw new Exception("Your passwords do not match");
        return 0;
    }
}

function validatePhone($phone) //Brad Campbell
{
    $phonePattern = "/^\+?[0-1]?\-?\(?\d{3}\)?\-?\d{3}\-?\d{4}$/";
    $phoneMatch = preg_match($phonePattern, $phone);
    return $phoneMatch;
}

function validateDD($dd)
{
	if($dd != "")
	{
		return 1;
	}
	else
	{
		return 0;
	}
}

}//End Validation Class
