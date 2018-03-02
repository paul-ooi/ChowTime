<?php
//Paul Ooi
//Password Validator takes in the value from the calling program and compares it to the RegEx. Returns a Boolean result. The function automatically assumes a null value if there's no value passed to the function and throws an appropriate error.
function password($userInput = null) {
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
 ?>
